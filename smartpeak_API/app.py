import requests
import numpy as np
from datetime import datetime, timezone, timedelta
from collections import Counter
from flask import Flask, request, jsonify
import json
import os
from dotenv import load_dotenv

load_dotenv()
GITHUB_TOKEN = os.getenv("GITHUB_TOKEN", "")

app = Flask(__name__)

# ─── Load Precomputed Artifacts from Colab ─────────────────────────────────────

with open('average_solution.json') as f:
    average_solution = json.load(f)

with open('encoders.json') as f:
    encoders = json.load(f)

# ─── Constants ─────────────────────────────────────────────────────────────────

WIB = timezone(timedelta(hours=7))

# ─── Helpers ───────────────────────────────────────────────────────────────────

def hour_to_slot(hour: int) -> str:
    hour = int(hour)
    if 5 <= hour < 12:
        return "Morning"
    elif 12 <= hour < 17:
        return "Afternoon"
    elif 17 <= hour < 21:
        return "Evening"
    else:
        return "Night"


def get_productive_hours(username: str) -> dict:
    url = f"https://api.github.com/users/{username}/events/public"

    headers = {"Accept": "application/vnd.github+json"}
    if GITHUB_TOKEN:
        headers["Authorization"] = f"Bearer {GITHUB_TOKEN}"

    try:
        response = requests.get(url, headers=headers, timeout=5)

        if response.status_code == 404:
            return {"slot": None, "confidence": 0, "reason": "github_user_not_found"}

        if response.status_code != 200:
            return {"slot": None, "confidence": 0, "reason": "github_api_error"}

        events = response.json()
        push_events = [e for e in events if e.get("type") == "PushEvent"]

        if len(push_events) < 5:
            return {"slot": None, "confidence": 0, "reason": "insufficient_data"}

        hours = []
        for event in push_events:
            created_at = event.get("created_at", "")
            if created_at:
                dt_utc = datetime.fromisoformat(created_at.replace("Z", "+00:00"))
                dt_wib = dt_utc.astimezone(WIB)
                hours.append(dt_wib.hour)

        slots = [hour_to_slot(h) for h in hours]
        slot_counts = Counter(slots)
        total = len(slots)

        dominant_slot = slot_counts.most_common(1)[0][0]
        confidence = slot_counts[dominant_slot] / total

        if confidence < 0.4:
            return {"slot": None, "confidence": round(confidence, 2), "reason": "low_confidence"}

        return {
            "slot": dominant_slot,
            "confidence": round(confidence, 2),
            "reason": "github_data"
        }

    except requests.exceptions.Timeout:
        return {"slot": None, "confidence": 0, "reason": "timeout"}
    except Exception as e:
        return {"slot": None, "confidence": 0, "reason": f"error: {str(e)}"}


def encode_features(raw: dict) -> dict:
    hours_map = {
        'Kurang dari 5 jam': 3,
        '5\u201310 jam':     7,
        '10\u201320 jam':    15,
        'Lebih dari 20 jam': 25,
    }

    org_map = {
        'Tidak terorganisir sama sekali': 1,
        'Kurang terorganisir':            2,
        'Cukup terorganisir':             3,
        'Sangat terorganisir':            4,
    }

    proc_map = {
        'Hampir tidak pernah': 1,
        'Jarang':              2,
        'Kadang-kadang':       3,
        'Sering':              4,
    }

    aids_map = {
        'Tidak pernah':  0,
        'Jarang':        1,
        'Kadang-kadang': 2,
        'Selalu':        3,
    }

    # Indonesian → encoders.json integer (location)
    # Cafe=0, Classroom=1, Home=2, Library=3
    location_map = {
        'Kafe':                0,
        'Kampus (luar kelas)': 1,
        'Rumah/Kos':           2,
        'Perpustakaan':        3,
    }

    # Indonesian → encoders.json integer (method)
    # Group Study=1, Note-taking=2, Practice Problems=3, Video Tutorials=5
    method_map = {
        'Auditori (rekaman, diskusi)':     1,
        'Membaca/Menulis (catatan, buku)': 2,
        'Kinestetik (praktik langsung)':   3,
        'Visual (diagram, video, warna)':  5,
    }

    return {
        'study_hours_weekly':    hours_map.get(raw.get('study_hours_weekly'), 7),
        'organization_level':    org_map.get(raw.get('organization_level'), 2),
        'procrastination_level': proc_map.get(raw.get('procrastination_level'), 2),
        'uses_study_aids':       aids_map.get(raw.get('uses_study_aids'), 1),
        'study_location':        location_map.get(raw.get('study_location'), 2),
        'study_method':          method_map.get(raw.get('study_method'), 4),
    }


# ─── EDAS Core ─────────────────────────────────────────────────────────────────

def run_edas(features: dict) -> dict:
    from edas_model import predict
    return predict(features)


# ─── Main Endpoint ─────────────────────────────────────────────────────────────

@app.route('/recommend', methods=['POST'])
def recommend():
    data = request.get_json()

    print("=" * 50)
    print("RECOMMEND CALLED")
    print("Data received:", json.dumps(data, indent=2))
    print("=" * 50)

    if not data:
        return jsonify({"error": "No data received"}), 400

    # 1. Encode text answers → numeric
    encoded = encode_features(data)
    print("Encoded features:", encoded)

    # 2. Run EDAS → returns {'skor': 0.72, 'rekomendasi': 'Morning'}
    try:
        edas_result = run_edas(encoded)
        print("EDAS result:", edas_result)
        edas_score          = float(edas_result['skor'])
        edas_recommendation = edas_result['rekomendasi']
    except Exception as e:
        return jsonify({"error": f"EDAS failed: {str(e)}"}), 500

    # 3. GitHub boost (fallback hierarchy)
    github_username  = data.get("github_username", "").strip()
    usual_study_hour = data.get("usual_study_hour")
    boost_slot   = None
    boost_source = "edas_only"

    if github_username:
        github_result = get_productive_hours(github_username)
        print("GitHub result:", github_result)
        if github_result["slot"]:
            boost_slot   = github_result["slot"]
            boost_source = "github"
        elif usual_study_hour is not None:
            boost_slot   = hour_to_slot(usual_study_hour)
            boost_source = "manual_input"
    elif usual_study_hour is not None:
        boost_slot   = hour_to_slot(usual_study_hour)
        boost_source = "manual_input"

    # 4. Apply boost logic
    # If GitHub/manual disagrees AND EDAS is borderline (< 0.55) → trust external source
    # If EDAS is confident (>= 0.55) → keep EDAS result
    final_recommendation = edas_recommendation

    if boost_slot and boost_slot != edas_recommendation:
        if edas_score < 0.55:
            final_recommendation = boost_slot
            boost_source         = boost_source + "_override"

    print(f"Final: {final_recommendation} | EDAS: {edas_recommendation} ({edas_score}) | Boost: {boost_slot} ({boost_source})")

    return jsonify({
        "success":             True,
        "recommendation":      final_recommendation,
        "edas_score":          edas_score,
        "edas_recommendation": edas_recommendation,
        "boost_source":        boost_source,
        "boost_slot":          boost_slot,
    })


# ─── Health Check ──────────────────────────────────────────────────────────────

@app.route('/health', methods=['GET'])
def health():
    return jsonify({"status": "ok"})


# ─── Entry Point ───────────────────────────────────────────────────────────────

if __name__ == '__main__':
    port = int(os.getenv("PORT", "5000"))
    debug = os.getenv("FLASK_DEBUG", "false").lower() == "true"
    app.run(host="0.0.0.0", port=port, debug=debug)
