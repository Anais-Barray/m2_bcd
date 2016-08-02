setwd("/home/siana/Documents/tp_an_prot") #repertoire courant ou chercher les fichiers
distrib_mass<-read.table("testdistrib.txt", sep="\t", dec=".", header=FALSE)
#View(distrib_mass)

plot(distrib_mass)
