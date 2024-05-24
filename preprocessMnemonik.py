import pandas as pd
import json

# Read the XLSX file into a pandas DataFrame
df = pd.read_excel('ХАРАКТ_ЗНАЧЕНИЕ.xlsx')

# Convert the DataFrame to a dictionary
data = df.to_dict('records')

# Create an empty dictionary to store the preprocessed data
preprocessed_data = {}

# Iterate over the data and populate the preprocessed_data dictionary
for item in data:
    и_знач_характ = item['И_ЗНАЧ_ХАРАКТ']
    м_знач_характ = item['М_ЗНАЧ_ХАРАКТ']
    
    if и_знач_характ not in preprocessed_data:
        preprocessed_data[и_знач_характ] = м_знач_характ

# Convert the preprocessed_data dictionary to JSON
json_data = json.dumps(preprocessed_data, ensure_ascii=False, indent=4)

# Decode the JSON data
decoded_data = json.loads(json_data)

# Write the JSON data to a file
with open('mnemonik.json', 'w', encoding='utf-8') as file:
    json.dump(decoded_data, file, ensure_ascii=False)