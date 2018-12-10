

def uploadToDb(groupId, schedule, dbCursor):
    date = "2000-01-01"
    startTime = "08:00:00"
    endTime = "10:30:00"
    name = "NazwaPrzedmiotu"
    lectName = "prof. Jan Kowlaski"
    place = "s.143"
    for entry in schedule:
        ### CLEANUP empty lines and split to have correct data
        pass

    fields = "('group_id', 'classes_date', 'classes_start_time', 'classes_end_time', 'classes_Name', 'lecturer_name', 'place')"
    vals = f"('{groupId}', '{date}', '{startTime}', '{endTime}', '{name}', '{lectName}', '{place}')"
    dbCursor.execute(f"INSERT INTO 'schedule' {fields} VALUES {vals}")
