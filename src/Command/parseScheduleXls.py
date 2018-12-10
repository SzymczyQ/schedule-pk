import pandas as pd
import xlrd
import numpy as np
import datetime
import math
from collections import OrderedDict

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

    umXls = df.as_matrix()
    umXls = remove_start_empty_rowes(umXls)

    return (umXls, umXls.shape[0], umXls.shape[1])

def parseSchFile(fName, cycle, year, group):

    schedule = list()
    umXls, rows, cols = getUnmargedExcelFile(fName)

    cycle = cycle.encode("latin-1", "ignore")
    year = year.encode("latin-1", "ignore")
    group = group.encode("latin-1", "ignore")

    # komórki pod złym kierunkiem na 'nan'
    for x in range(cols):
        cellVal = str(umXls[0, x]).encode("latin-1", "ignore")
        if cellVal != cycle:
            umXls[:, x] = float('nan')

    #komorki pod innym rokiem i grupa na NAN, jezeli grupa i rok nie znana zostaje
    for x in range(cols):
        cellVal = str(umXls[1, x]).encode("latin-1", "ignore")
        if cellVal != 'nan' and cellVal != year:
            umXls[:, x] = float('nan')
        elif cellVal == year:
            cell2Val = str(int(umXls[2, x])).encode("latin-1", "ignore")
            if cell2Val != group:
                umXls[:, x] = float('nan')
    
    #wpisywanie do listy jezeli linijka zaczyna sie od data oraz takiej lini nie ma w classes
    for x in range(3, rows):
        l = []
        val1 = str(umXls[x])
        val2 = str(umXls[x-1])
        val3 = umXls[x][0]
        if val1 != val2 and type(val3) is int:
            for y in val1:
                if str(y) != 'nan':
                    l.append(y)
        l = unique_list(l)
        if len(l) > 2:
            schedule.append(l[:-1]) if l[-1] == l[-2] else schedule.append(l)

    return schedule