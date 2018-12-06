#!/usr/bin/env python3

import mysql.connector
import urllib.request
from lxml import html
import requests
import re
import parseScheduleXls

scheduleDb = mysql.connector.connect(
  host = "pma.podzialpk.pl",
  user = "schedulepk",
  passwd = "schedulepk",
  database = "schedule_pk"
)

dbCursor = scheduleDb.cursor()

dbCursor.execute("SELECT value FROM config WHERE token = 'baseUrl'")
pageUrl = dbCursor.fetchone()[0]

dbCursor.execute("SELECT value FROM config WHERE token = 'schedulyQueryString'")
schQueryString = dbCursor.fetchone()[0]

dbCursor.execute("SELECT value FROM config WHERE token = 'currentScheduleFile'")
currentSchduleFileName = dbCursor.fetchone()[0]

dbCursor.execute("SELECT value FROM config WHERE token = 'scheduleNameRegex'")
schNameRegex = dbCursor.fetchone()[0]

### Get the page and find all links with "file" beeing part of URL string
schPage = html.fromstring(urllib.request.urlopen(pageUrl + schQueryString).read())

filesLinks = list()
for link in schPage.xpath("//a"):
    linkUrl = link.get("href")
    if linkUrl:
        if "file" in linkUrl:
            if "http" not in linkUrl:
                filesLinks.append(pageUrl + linkUrl)
            else:
                filesLinks.append(linkUrl)

for l in filesLinks:
    fName = ""
    req = requests.get(l)
    contentDisp = req.headers._store.get("content-disposition")
    if contentDisp != None:
        vals = contentDisp[1].split(";")
        fName = vals[1].split("=")[1].replace('"', '')
    if fName != None and fName != "":
        if re.match(schNameRegex, fName):
            dbCursor.execute("UPDATE config SET value = "
                             "'{}' WHERE token = 'currentScheduleFile'".format(fName))
            ### REMOVE THE COMMENT BELOW WHEN TESTING FINISHED !!!!
            #scheduleDb.commit()
            if fName != currentSchduleFileName:
                with open(fName, 'wb') as f:
                    f.write(req.content)
                parseScheduleXls.parseSchFile(fName)