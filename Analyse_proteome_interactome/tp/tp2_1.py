#!/usr/bin/python

''' This program offers a solution for the exercise 1 of TP 2.

Its objective is to compute the fragment masses of a given peptide (string input in shell command) 
in various types and number of charges. For every type (a,b,c,y,b++,y++), a function will compute 
each possible fragment's masses (refer to formulas of 2nd lesson).
The table-like output displayed on the shell screen consists of the commputed masses for the various fragments.

An example of call would be : ./tp2_1.py KVPQVSTPTLR
'''

import sys, os, subprocess

#dictionary of amino acids and molecules masses
dico_mass={'A':71.03711,'R':156.10111,'N':114.04293,'D':115.02694,'C':103.00919,'E':129.04259,
'Q':128.05858,'G':57.02146,'H':137.05891,'I':113.08406,'L':113.08406,'K':128.09496,'M':131.04049,
'F':147.06841,'P':97.05276,'S':87.03203,'T':101.04768,'W':186.07931,'Y':163.06333,'V':99.06841,
 "H2O":18.01056, "H3O":19.0184046, "NH3":17.02656, "OC":27.9949146, "Hy":1.00783, "H3":3.02349}
	
#------------------------------------------------------------------------------------------------#

def a_frag_mass(seq) :

	mass_frag=dico_mass[seq[0]]
	list_a_frag_mass=[]
	
	for aa in seq[1:len(seq)-1]: 
		mass_temp=0
		mass_frag = mass_frag + dico_mass[aa]
		mass_temp=mass_frag+dico_mass["Hy"]-dico_mass["OC"]
		list_a_frag_mass.append(mass_temp)

	return list_a_frag_mass
		
#------------------------------------------------------------------------------------------------#

def b_frag_mass(seq) :

	mass_frag=dico_mass[seq[0]]
	list_b_frag_mass=[]
	
	for aa in seq[1:len(seq)-1]: 
		mass_temp=0
		mass_frag = mass_frag + dico_mass[aa]
		mass_temp=mass_frag+dico_mass["Hy"]
		list_b_frag_mass.append(mass_temp)
		
	return list_b_frag_mass	
		
#------------------------------------------------------------------------------------------------#

def c_frag_mass(seq) :

	mass_frag=dico_mass[seq[0]]
	list_c_frag_mass=[]

	for aa in seq[1:len(seq)-1]: 
		mass_temp=0
		mass_frag = mass_frag + dico_mass[aa]
		mass_temp=mass_frag+dico_mass["NH3"]
		list_c_frag_mass.append(mass_temp)
	
	return list_c_frag_mass	
	
#------------------------------------------------------------------------------------------------#
	
def y_frag_mass(seq) :
	
	mass_frag=0
	list_y_frag_mass=[]
	
	for i in range(len(seq)-1, 0, -1):
		for aa in seq[i]: 
			mass_temp=0	
			mass_frag = mass_frag + dico_mass[aa]
			mass_temp = mass_frag + dico_mass["H3O"]
			list_y_frag_mass.append(mass_temp)
				
	return list_y_frag_mass[::-1]
	
#------------------------------------------------------------------------------------------------#

def bpp_frag_mass(seq) :

	mass_frag=(dico_mass[seq[0]])/2
	list_bpp_frag_mass=[]
	
	for aa in seq[1:len(seq)-1]: 
		mass_temp=0
		mass_frag = mass_frag + (dico_mass[aa])/2
		mass_temp = mass_frag + dico_mass["Hy"]
		list_bpp_frag_mass.append(mass_temp)
		
	return list_bpp_frag_mass	
		
#------------------------------------------------------------------------------------------------#
	
def ypp_frag_mass(seq) :
	
	mass_frag=0
	list_ypp_frag_mass=[]
	
	for i in range(len(seq)-1, 0, -1):
		for aa in seq[i]: 
			mass_temp=0	
			mass_frag = mass_frag + (dico_mass[aa])/2
			mass_temp = mass_frag + (dico_mass["Hy"] + dico_mass["H3O"])/2
			list_ypp_frag_mass.append(mass_temp)
		
	return list_ypp_frag_mass[::-1]
	
#------------------------------------------------------------------------------------------------#

def usage():
	print ("Please respect the input format : ./tp2_1.py <peptide sequence>")
	sys.exit()

#------------------------------------------------------------------------------------------------#
			
def main():	
	subprocess.call("clear")	
	print ("****************************************************** START OF PROGRAM ******************************************************\n\n")
	
	if len(sys.argv)!=2:
		print usage()
	else : 
		seq = (sys.argv[1])
		for aa in seq :
			if aa not in dico_mass :
				sys.stderr.write("Error : Please input a sequence with no ambiguous amino acid\n")
				sys.exit(1)
		print "The types and fragments' masses (Da) of the protein sequence", seq, "are : \n"
		print "       |   "+"    |   ".join(list(seq))+"   |"
		print "a : \t\t ",('   '.join([str("%.2f" % mass) for mass in a_frag_mass(seq) ] ) )
		print "b : \t\t ",('   '.join([str("%.2f" % mass) for mass in b_frag_mass(seq) ] ) )
		print "c : \t\t ",('   '.join([str("%.2f" % mass) for mass in c_frag_mass(seq) ] ) )
		print "y : \t\t ",('   '.join([str("%.2f" % mass) for mass in y_frag_mass(seq) ] ) )
		print "b++ : \t\t ",('   '.join([str("%.2f" % mass) for mass in bpp_frag_mass(seq) ] ) )
		print "y++ : \t\t ",('   '.join([str("%.2f" % mass) for mass in ypp_frag_mass(seq) ] ) )
		
	print ("\n\n****************************************************** END OF PROGRAM ******************************************************\n\n")
	
	sys.exit()
	
if __name__ == "__main__":
	main()
