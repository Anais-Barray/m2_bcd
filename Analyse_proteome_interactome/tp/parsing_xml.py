#!/usr/bin/python
import sys,os,re,string,operator
from tp2_1 import *
#ce script prend en entree un fichier XML. Exemple d'appel : ./parsing_xml.py identifications_spectres.xml

#------------------------------------------------------------------------------------------------#

def parsing_xml_seq_peaks(f):
	
	dico_seq_pic = {}
	peaks = False
	
	#parse un fichier xml, cherche les sequences, et les pics experimentaux, les stock dans un dico.
	for line in f:
		
		seq=re.search("<idi:sequence>(.+)</idi:sequence>", line)
		#charge=re.search("<idi:charge>([0-9]+)</idi:charge>", line)	
				
		if (seq):
			sequence=seq.group(1)
			dico_seq_pic[sequence]=[]
			
		if ("<ple:peaks><![CDATA[" in line):
			peaks = True
			
		elif ("]]></ple:peaks>" in line):
			peaks = False
			
		elif (peaks == True):
			line=line.split()
			dico_seq_pic[sequence].append((line[0],line[1]))
		
	return dico_seq_pic

#------------------------------------------------------------------------------------------------#

def fragment_ratios(peptide,list_peaks,mass_tolerance=0.3):
	#creation de listes des masses (pics theoriques) pour chaque fragment d'un peptide
	a_list_mass = a_frag_mass(peptide)
	b_list_mass = b_frag_mass(peptide)
	c_list_mass = c_frag_mass(peptide)
	y_list_mass = y_frag_mass(peptide)
	bpp_list_mass = bpp_frag_mass(peptide)
	ypp_list_mass = ypp_frag_mass(peptide)
	cpt_a = cpt_b = cpt_c = cpt_y = cpt_bpp = cpt_ypp = 0 #compteur d'occurence de chaque fragment
	dico_ratio = {}
	
	#parcours tous les pics experimentaux d'un peptide donne
	for picExp in list_peaks:
		
		#pour chaque type de fragment, si picTheo et picExp sont egaux +/- 0.3Da, on incremente le compteur d'occurence du fragment.
		for picTheo in a_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				cpt_a+=1

		for picTheo in b_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				cpt_b+=1
	
		for picTheo in c_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				cpt_c+=1
				
		for picTheo in y_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				cpt_y+=1

		for picTheo in bpp_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				cpt_bpp+=1

		for picTheo in ypp_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				cpt_ypp+=1
	
	#ajout des ratio (nb trouve/nb total) de chaque fragment a un dictionnaire
	dico_ratio["a_ratio"]=(float(cpt_a)/(len(a_list_mass)))	
	dico_ratio["b_ratio"]=(float(cpt_b)/(len(b_list_mass)))
	dico_ratio["c_ratio"]=(float(cpt_c)/(len(c_list_mass)))
	dico_ratio["y_ratio"]=(float(cpt_y)/(len(y_list_mass)))
	dico_ratio["bpp_ratio"]=(float(cpt_bpp)/(len(bpp_list_mass)))
	dico_ratio["ypp_ratio"]=(float(cpt_ypp)/(len(ypp_list_mass)))
	
	return dico_ratio
	
#------------------------------------------------------------------------------------------------#

def distrib_diff_mass(peptide,list_peaks,mass_tolerance=0.3):
	#creation de listes des masses (pics theoriques) pour chaque fragment d'un peptide
	a_list_mass = a_frag_mass(peptide)
	b_list_mass = b_frag_mass(peptide)
	c_list_mass = c_frag_mass(peptide)
	y_list_mass = y_frag_mass(peptide)
	bpp_list_mass = bpp_frag_mass(peptide)
	ypp_list_mass = ypp_frag_mass(peptide)
	list_diff_mass_exp_th = []
	
	#parcours tous les pics experimentaux d'un peptide donne
	for picExp in list_peaks:
		
		#pour chaque type de fragment, si picTheo et picExp sont egaux +/- 0.3Da, on incremente le compteur d'occurence du fragment.
		for picTheo in a_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(abs(float(picTheo)-float(picExp)))

		for picTheo in b_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(abs(float(picTheo)-float(picExp)))
	
		for picTheo in c_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(abs(float(picTheo)-float(picExp)))
				
		for picTheo in y_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(abs(float(picTheo)-float(picExp)))

		for picTheo in bpp_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(abs(float(picTheo)-float(picExp)))

		for picTheo in ypp_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(abs(float(picTheo)-float(picExp)))
				
	return list_diff_mass_exp_th

#------------------------------------------------------------------------------------------------#
#TODO
def intensity_found(peptide,list_peaks,mass_tolerance=0.3):
	#creation de listes des masses (pics theoriques) pour chaque fragment d'un peptide
	a_list_mass = a_frag_mass(peptide)
	b_list_mass = b_frag_mass(peptide)
	c_list_mass = c_frag_mass(peptide)
	y_list_mass = y_frag_mass(peptide)
	bpp_list_mass = bpp_frag_mass(peptide)
	ypp_list_mass = ypp_frag_mass(peptide)
	intensity_sum=0
	
	#parcours tous les pics experimentaux d'un peptide donne
	for picExp in list_peaks:
		
		#pour chaque type de fragment, si picTheo et picExp sont egaux +/- 0.3Da, on incremente le compteur d'occurence du fragment.
		for picTheo in a_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(float(picTheo)-float(picExp))

		for picTheo in b_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(float(picTheo)-float(picExp))
	
		for picTheo in c_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(float(picTheo)-float(picExp))
				
		for picTheo in y_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(float(picTheo)-float(picExp))

		for picTheo in bpp_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(float(picTheo)-float(picExp))

		for picTheo in ypp_list_mass: 
			if ((float(picTheo)-float(picExp)<mass_tolerance and float(picTheo)-float(picExp)>0) or (float(picExp)-float(picTheo)<mass_tolerance and float(picExp)-float(picTheo)>0)):
				list_diff_mass_exp_th.append(float(picTheo)-float(picExp))
				
	return intensity_sum
	
		
#------------------------------------------------------------------------------------------------#				
								
def main(): 
	
	f = open(sys.argv[1])
	output = open(sys.argv[2],'w')
	mass_tolerance = float(sys.argv[3])
	dico_seq_peaks=parsing_xml_seq_peaks(f) #contient les sequences et pics experimentaux de chaque element XML
	dico_ratio_pept_global={} #A chaque type de fragment (cle), va contenir les ratios pour chaque peptide (liste)
	dico_ratio_random_global={} #idem pour les fragments aleatoires
	list_diff_mass_global = []
	list_diff_mass_random_global = []
	
	subprocess.call("clear")
	print ("****************************************************** START OF PROGRAM ******************************************************\n\n")

	
	#parse chaque peptide du dico, puis calcul des ratios des fragments de type a,b,c,b++,y++ 
	for peptide in dico_seq_peaks.keys() :
		
		dico_ratio_pept = fragment_ratios(peptide,[m for m,i in dico_seq_peaks[peptide]],mass_tolerance)
		dico_ratio_random = fragment_ratios(peptide[::-1],[m for m,i in dico_seq_peaks[peptide]],mass_tolerance) #faire le reverse du peptide pour tester les faux positifs (bruit), chance de trouver aleatoirement des bons pics
		print "############ Fragment type ratios of peptide",peptide,"############ :\n",dico_ratio_pept
		#print "*** The highest fragment type ratio is",max(dico_ratio_pept.iteritems(), key=operator.itemgetter(1))[0],":",max(dico_ratio_pept.iteritems(), key=operator.itemgetter(1))[1],"***\n"
		print "Random fragment type ratios (noise) :\n",dico_ratio_random,"\n\n"
		#print "*** The highest random fragment type ratio (noise) is",max(dico_ratio_reverse.iteritems(), key=operator.itemgetter(1))[0],":",max(dico_ratio_reverse.iteritems(), key=operator.itemgetter(1))[1],"***\n\n"
		
		#ajout des ratio dans les dico globaux a la cle type_frag
		for type_frag in dico_ratio_pept.keys():
			if (type_frag not in dico_ratio_pept_global.keys()):
				dico_ratio_pept_global[type_frag]=[]
			dico_ratio_pept_global[type_frag].append(dico_ratio_pept[type_frag])
			
		for type_frag in dico_ratio_random.keys():
			if (type_frag not in dico_ratio_random_global.keys()):
				dico_ratio_random_global[type_frag]=[]
			dico_ratio_random_global[type_frag].append(dico_ratio_random[type_frag])
	
		#ajout des differences de masse expliquees dans les listes dediees.
		list_diff_mass_global.extend(distrib_diff_mass(peptide,[m for m,i in dico_seq_peaks[peptide]],mass_tolerance))
		list_diff_mass_random_global.extend(distrib_diff_mass(peptide[::-1],[m for m,i in dico_seq_peaks[peptide]],mass_tolerance))
		
	#moyenne des ratio pour chaque fragment trouve
	print "Ratio of found fragments' types : \n"
	for type_frag in dico_ratio_pept_global.keys():
		print type_frag," : ",sum(dico_ratio_pept_global[type_frag])/float(len(dico_ratio_pept_global[type_frag]))
	#moyenne des ratio pour chaque fragment aleatoire	
	print "\nRatio of random fragments' types: \n"
	for type_frag in dico_ratio_random_global.keys():
		print type_frag," : ",sum(dico_ratio_random_global[type_frag])/float(len(dico_ratio_random_global[type_frag]))
		
	#moyenne des differences des masses expliquees	
	print "\nMean of the found masses' differences for a tolerance of",mass_tolerance,"Da is :",(sum(list_diff_mass_global)/len(list_diff_mass_global))
	#moyenne des differences des masses aleatoires expliquees	
	print "\nMean of the random found masses' differences :",(sum(list_diff_mass_random_global)/len(list_diff_mass_random_global))

	for diff_mass in list_diff_mass_global :
		output.write(str(diff_mass))
		output.write("\n")

	print ("\n\n****************************************************** END OF PROGRAM ******************************************************\n\n")
		
	f.close()
	output.close()
	sys.exit()
	
if __name__ == "__main__":
	main()
