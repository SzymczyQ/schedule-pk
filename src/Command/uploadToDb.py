from datetime import datetime
from database_binding import dbConnection, Schedule
def dateFromNumber(number):    
    dt = datetime.fromordinal(datetime(1900, 1, 1).toordinal() + number - 2)
    dt = dt.strftime("%Y-%m-%d")
    return dt

def uploadToDb(gId, schedule):
    dbConn = dbConnection()    
    for entry in schedule:
        date = "2000-01-01"
        startTime = "00:00:01"
        endTime = "00:00:02"        
        date = dateFromNumber(entry[0])
        t = entry[1].replace(".", ":").split("-")
        if len(t) < 2: continue
        startTime = "{}:00".format(t[0])
        endTime = "{}:00".format(t[1])
        for clss in entry[2:]:
            name = "empty"
            lectName = "noNameProvided"
            plc = "placeNotSpecified"
            s = clss.split("\n")
            try:
                name = s[0]
                lectName = s[1]
                plc = s[2]
            except IndexError:
                pass
            finally:
                dbConn.Add( Schedule(group_id = gId,
                                     classes_date = date,
                                     classes_start_time = startTime,
                                     classes_end_time = endTime,
                                     classes_Name = name,
                                     lecturer_name = lectName, place = plc) )