import pandas as pd
import numpy as np
import datetime
from collections import OrderedDict
import sys

def unique_list(l):
	return list(OrderedDict.fromkeys(l))

def read_excel_to_matrix(path):
	df = pd.read_excel(path,0)
	return df.as_matrix()
	
if __name__ == "__main__":
	#Uzycie py skrt2.py "Rok" Grupa input_excel output.txt kod raczej działa input jest wykorzystujacy makro"
				
	Rok = sys.argv[1]
	Grupa = sys.argv[2]
	input_excel_path = sys.argv[3]
	output_txt_path = sys.argv[4] 
	
	a = read_excel_to_matrix(input_excel_path)
	rows = a.shape[0]
	cols = a.shape[1]

	#komorki pod innym rokiem i grupa na NAN, jezeli grupa i rok nie znana  zostaje
	for x in range(cols):
		if str(a[0][x]) != 'nan' and str(a[0][x]) != Rok:
			for y in range (rows):
				a[y][x] = 'nan'
		elif str(a[0][x]) == Rok:
			if str(a[1][x]) != Grupa:
				for y in range (rows):
					a[y][x] = 'nan'
	
	#lsita z zajrciami [data format datetiem, godzina format str, reszta format str]
	classes = []
	
	#wpisywanie do listy jezeli linijka zaczyna sie od data oraz takiej lini nie ma w classes
	for x in range(1,rows):
		l = []
		if str(a[x]) != str(a[x-1]) and type(a[x][0]) is datetime.datetime:
			for y in a[x]:
				if str(y) != 'nan':
					l .append(y)
		l = unique_list(l)
		if len(l) > 2:
			classes.append(l[:-1]) if l[-1] == l[-2] else classes.append(l)	
 
	# zapis do TXT tutaj mozna zrobic jakis export zamiast tego
	with open(output_txt_path, 'w') as output:
		for x in classes:
			output.write('\n\n')
			output.write(str(x))

 