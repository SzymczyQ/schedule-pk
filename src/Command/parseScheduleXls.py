import pandas as pd
from pandas import ExcelWriter
import xlrd
import numpy as np
import datetime
import math
from collections import OrderedDict
import os

def unique_list(l):
    return list(OrderedDict.fromkeys(l))

def remove_start_empty_rowes(matrix):
    while all(map(lambda x: type(x) is float, matrix[0])):
        if all(map(lambda x: math.isnan(x), matrix[0])):
            matrix = np.delete(matrix, 0 , 0)
    return matrix

def getUnmargedExcelFile(fName):
    exc = pd.ExcelFile(xlrd.open_workbook(fName, formatting_info = True), engine = 'xlrd')
    sht = exc.book.sheet_by_index(0)
    df = exc.parse(0, header = None)

    for r1, rh, c1, ch in sht.merged_cells:
        df.iloc[r1:rh, c1:ch] = sht.cell_value(r1, c1)

    path = os.path.dirname(os.path.abspath(__file__))
    fPath = f"{path}/temp.xls"
    writer = ExcelWriter(fPath)
    df.to_excel(writer,'Sheet1', index = False)
    writer.save()

    df = pd.read_excel(fPath)

    umXls = df.as_matrix()
    umXls = remove_start_empty_rowes(umXls)

    return (umXls, umXls.shape[0], umXls.shape[1])

def parseSchFile(fName, cycle, year, group):

    schedule = list()
    umXls, rows, cols = getUnmargedExcelFile(fName)

    # komórki pod złym kierunkiem na 'nan'
    for x in range(cols):
        cellVal = str(umXls[0, x]).strip(" ")
        if cellVal != cycle:
            umXls[:, x] = float('nan')

    #komorki pod innym rokiem i grupa na NAN, jezeli grupa i rok nie znana zostaje
    for x in range(cols):
        cellVal = str(umXls[1, x])
        if cellVal != 'nan' and cellVal != year:
            umXls[:, x] = float('nan')
        elif cellVal == year:
            cell2Val = str(umXls[2, x])
            if cell2Val != group:
                umXls[:, x] = float('nan')
    
    #wpisywanie do listy jezeli linijka zaczyna sie od data oraz takiej lini nie ma w classes
    for x in range(3, rows):
        l = []
        val1 = umXls[x]
        val2 = umXls[x-1]
        val3 = umXls[x][0]
        val4 = umXls[x][18]
        if (str(val1) != str(val2) and 
           (type(val3) is int or type(val4) is int)):
            for y in val1:
                if str(y) != 'nan':
                    l.append(y)
        l = unique_list(l)
        if len(l) > 2:
            schedule.append(l[:-1]) if l[-1] == l[-2] else schedule.append(l)

    return schedule