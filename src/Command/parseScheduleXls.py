import pandas as pd
import xlrd

def parseSchFile(fName, year, group):

    exc = pd.ExcelFile(xlrd.open_workbook(fName, formatting_info = True), engine = 'xlrd')
    sht = exc.book.sheet_by_index(0)
    df = exc.parse(0, header = None)

    for r1, rh, c1, ch in sht.merged_cells:
        df.iloc[r1:rh, c1:ch] = sht.cell_value(r1, c1)

    ### df now contains all necessery data with unmarged cells
    ### TODO: Parse the df and store the data somehow

    ##
    ##
    ##

    ### File parsed to 