#!/usr/bin/python
import sys, os, string, subprocess

#~ seq = "MRPFFVPLFLVGILFPAILAKQFTKCELSQLLKDIDGYGGIALPELICTMFHTSGYDTQAIVENNESTEYGLFQISNKPLWCKSSQVPQSRNICDISCDKFLDDDITDDIMCAKKILDIKGIDYWLAHKALCTEKLEQWLCEKL"
dico_mw={'A':71.03711,'R':156.10111,'N':114.04293,'D':115.02694,'C':103.00919,'E':129.04259,'Q':128.05858,'G':57.02146,'H':137.05891,'I':113.08406,'L':113.08406,'K':128.09496,'M':131.04049,'F':147.06841,'P':97.05276,'S':87.03203,'T':101.04768,'W':186.07931,'Y':163.06333,'V':99.06841,"H2O":18.01056}
	

#------------------------------------------------------------------------------------------------#

def liste_fragment(seq) :
	i=0
	liste_fragment=[]
	
	#realise des peptides (fragments) a partir de la sequence, definiq entre i et j.
	#digestion de la sequence par la trypsine apres acides amines R et K si non suivies par P
	for j in range (0,len(seq)-1):
		if ((seq[j] in ('R','K')) and (seq[j+1] is not 'P')) :
			liste_fragment.append(seq[i:j+1]) #ajout du fragment a la liste
			i = j+1  #creation d'un nouveau fragment
		
	liste_fragment.extend(seq[i:len(seq)]) #ajout du dernier fragment
	return liste_fragment

#------------------------------------------------------------------------------------------------#

def liste_fragment_miss(liste_fragment, nb_miss) :

	liste_fragment_missed = []
	
	#realise des fragments avec nb_miss missed cleavage (erreur de digestion de la trypsine)
	#ex : proteine coupee en fragments A B C D E, si trypsine a 2 missed cleavage, produit les fragments supplementaires AB BC CD DE et ABC BCD CDE	
	for i in range (0,len(liste_fragment)-nb_miss):
		liste_fragment_missed.append(''.join(liste_fragment[i:(i+nb_miss+1)]))
	
	return liste_fragment_missed
	
#------------------------------------------------------------------------------------------------#

def digestion_with_missed_cleavage(seq,nb_miss=0) :
	liste_frag = liste_fragment(seq)
	liste_frag_final = liste_fragment(seq)

	#realise les autres fragments produits si nb_miss > 0. Recursive de liste_fragment_miss() pour tous les nb_miss possibles
	if (nb_miss>0):
		for i in range (1, nb_miss+1):
			liste_frag_final.extend(liste_fragment_miss(liste_frag, i))
	
	return liste_frag_final
	
#------------------------------------------------------------------------------------------------#

def fragment_mass_weight(liste_frag):
	liste_frag_mw={}
	
	#fait la somme des aa d'un fragment a partir du dico de mw. ajoute un H2O (aa en bordure du fragment non inclus dans une liaison peptidique)
	for frag in liste_frag:
		if 'X' not in frag and 'Z' not in frag and 'B' not in frag and 'U' not in frag and 'J' not in frag and 'O' not in frag :
			mw_frag = 0
			mw_frag=sum(dico_mw[aa] for aa in frag)+dico_mw["H2O"]
			liste_frag_mw[frag]=mw_frag
		else :
			continue
			
	for key in liste_frag_mw:
		print key+"\t"+(liste_frag_mw[key])
		

	
#------------------------------------------------------------------------------------------------#

def fragment_mass_weight2(liste_frag):
	liste_frag_mw=[]
	
	#fait la somme des aa d'un fragment a partir du dico de mw. ajoute un H2O (aa en bordure du fragment non inclus dans une liaison peptidique)
	for frag in liste_frag:
		if 'X' not in frag and 'Z' not in frag and 'B' not in frag and 'U' not in frag and 'J' not in frag and 'O' not in frag :
			mw_frag = 0
			mw_frag=sum(dico_mw[aa] for aa in frag)+dico_mw["H2O"]
			liste_frag_mw.append(mw_frag)
		else :
			continue

	return liste_frag_mw
	#~ for mw in liste_frag_mw:
		#~ print mw
	
#------------------------------------------------------------------------------------------------#

#calcul la distribution des masses des fragments, dans le but de visualiser la courbe de tendance des masses sous R
def distrib_mw(mw_digest_file):
	dico_distrib_mw={}

	#parcours chaque masse du fichier. Ajoute +1 a la cle du dictionnaire correspondant au range de la masse. 
	#Ex masse de 174.125 ajoutee a la cle 1, masse 2236.98 ajoutee a la cle 22.
	for mw in mw_digest_file:
		mw = mw.strip()
		dico_distrib_mw[int(float(mw))/100] = dico_distrib_mw[int(float(mw))/100] + 1 if int(float(mw))/100 in dico_distrib_mw.keys() else 1

	return dico_distrib_mw
	
#------------------------------------------------------------------------------------------------#

def usage():
	print ("Please respect the input format : <number of missed cleavage<=0> <file>")

#------------------------------------------------------------------------------------------------#

def main():	
	subprocess.call("clear")	
	print ("****************************************************** START OF PROGRAM ******************************************************\n\n")
	#~ #if len(sys.argv)>1 :
	#~ #	print (">>>Fragments produced with trypsine digestion (%d missed cleavage(s))  :  " %int(sys.argv[1]))
	#~ #	print (digestion_with_missed_cleavage(int(sys.argv[1])))
	#~ #	print "\n>>>Protein sequence total weight : %d Da" %(sum(dico_mw[aa] for aa in seq)+dico_mw["H2O"])
	#~ #	print "\n>>>Values of the fragments' weights (Da) : "
	#~ #	print (fragment_mass_weight(digestion_with_missed_cleavage(int(sys.argv[1]))))
	#~ #else : 
	#~ #	print ("Please input a number of missed cleavage (>=0)")
	#~ 
	#~ if len(sys.argv)<3 :
		#~ print usage()
	#~ else : 
		#~ f = open(sys.argv[2])
		#~ seq=""
		#~ for line in f:
			#~ line=line.strip()
			#~ if line[0]=='>':
				#~ if seq!="" :
					#~ (fragment_mass_weight(digestion_with_missed_cleavage(seq,int(sys.argv[1]))))
					#~ print
				#~ words=line.split()
				#~ words[0]=words[0][1:]
				#~ print ">>> sequence id :", words[0]
				#~ seq=""
			#~ else :
				#~ seq=seq+line
		#~ (fragment_mass_weight(digestion_with_missed_cleavage(seq,int(sys.argv[1]))))
		#~ f.close()

	if len(sys.argv)<3 :
		print usage()
	else : 
		f = open(sys.argv[2])						#fichier contenant les sequences proteines
		mw_digest_file = open(sys.argv[3], 'w+')	#fichier qui contiendra les masses des fragments (sequences digerees)
		distrib_file = open(sys.argv[4],'w')		#fichier qui contiendra les range de masse avec le nombre de fragment associe
		
		#premiere etape : digerer les sequences contenues dans f et ecrire les masses correspondantes a chaque fragment dans mw_digest_file
		print "...Digestion of protein sequences of file <",sys.argv[2],"> and computation of the weight of each fragment..."
		seq=""
		for line in f:
			line=line.strip()
			if line[0]=='>':
				if seq!="" :
					for weight in fragment_mass_weight2(digestion_with_missed_cleavage(seq,int(sys.argv[1]))):
						if weight is not None:
							mw_digest_file.write(str(weight)+"\n")
				seq=""
			else :
				seq=seq+line
		for weight in fragment_mass_weight2(digestion_with_missed_cleavage(seq,int(sys.argv[1]))):
			if weight is not None:
				mw_digest_file.write(str(weight)+"\n")
		f.close()

		#seconde etape : calculer le nombre de masses contenues dans chaque range (0, 100, 200...)
		mw_digest_file.seek(0)
		dico_distrib = (distrib_mw(mw_digest_file))
		mw_digest_file.close()

		print "\nDistribution of fragments' length : "
		for key in dico_distrib:
			line = ""+str(int(key)*100)+"\t"+str(dico_distrib[key])+"\n"
			print line.strip()
			distrib_file.write(line)
		distrib_file.close()

	print ("\n\n****************************************************** END OF PROGRAM ******************************************************\n\n")

if __name__ == "__main__":
	main()
