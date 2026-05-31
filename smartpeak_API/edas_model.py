import numpy as np
import json

with open('average_solution.json') as f:
    AV = np.array(list(json.load(f).values()))

with open('encoders.json') as f:
    encoders = json.load(f)

WEIGHTS    = np.array([0.25, 0.20, 0.15, 0.15, 0.10, 0.15])
IS_BENEFIT = [True, True, True, True, True, False]

def encode_input(data):
    return np.array([
        float(data['study_hours_weekly']),
        float(data['organization_level']),
        float(data['uses_study_aids']),
        float(data['study_location']),
        float(data['study_method']),
        float(data['procrastination_level']),
    ])

def predict(data):
    row = encode_input(data)
    
    PDA = np.zeros(len(row))
    NDA = np.zeros(len(row))
    
    for j in range(len(row)):
        if IS_BENEFIT[j]:
            PDA[j] = max(0, (row[j] - AV[j])) / (AV[j] + 1e-9)
            NDA[j] = max(0, (AV[j] - row[j])) / (AV[j] + 1e-9)
        else:
            PDA[j] = max(0, (AV[j] - row[j])) / (AV[j] + 1e-9)
            NDA[j] = max(0, (row[j] - AV[j])) / (AV[j] + 1e-9)
    
    SP = float((PDA * WEIGHTS).sum())
    SN = float((NDA * WEIGHTS).sum())
    
    # Untuk single prediction, normalisasi SP dan SN pakai range 0-1 langsung
    NSP = min(SP, 1.0)
    NSN = 1 - min(SN, 1.0)
    AS  = 0.5 * (NSP + NSN)
    
    if AS >= 0.75:   rek = 'Morning'
    elif AS >= 0.55: rek = 'Afternoon'
    elif AS >= 0.35: rek = 'Evening'
    else:            rek = 'Night'
    
    return {'skor': round(AS, 4), 'rekomendasi': rek}