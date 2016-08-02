#include <cstdlib>
#include <cstdio>
#include <cstring>
#include <iostream>
#include <fstream>
#include <vector>
#include <string>


using namespace std;


class PeptidePosition
{
public:
  PeptidePosition():first(-1),last(-1),length(-1),nmc(0) {}
  PeptidePosition(int f, int l, int len, int n){
    first = f;
    last = l;
    length = len;
    nmc = n;
  }
  ~PeptidePosition(){}

  int first, last, length, nmc;

}; // class PeptidePosition


// Global variables to store basic masses
vector<double> aaMasses;
double waterMass, protonMass;


void readAAMasses(const string fName, vector<double>& aaMasses, double& water, double& proton)
{
  // Minimal parsing of the file containing aa masses
  aaMasses.assign('Z', -1.0e10);
  ifstream mfile(fName.c_str());
  string dummy;
  mfile >> dummy;
  for (int i = 0; i < 20; i++){
    char aa;
    double mass;
    mfile >> aa >> mass;
    aaMasses[aa] = mass;
  }
  aaMasses['C'] += 57.02146;
  waterMass = 18.01056;
  protonMass = 1.00728;

} // readAAMasses


double getPeptideMass(const string& protein, const PeptidePosition& pos)
{
  // Computes a peptide mass
  double mass = waterMass;
  for (int i = pos.first; i <= pos.last; i++)
    mass += aaMasses[protein[i]];
  return mass;

} // getPeptideMass


double getPeptideMass(const string& peptide)
{
  // Computes a peptide mass
  double mass = waterMass;
  for (int i = 0; i < peptide.length(); i++)
    mass += aaMasses[peptide[i]];
  return mass;

} // getPeptideMass


void digestByTrypsin(const string& protein, int nmc, vector<PeptidePosition>& pept)
{
  // Digestion by trypsin with a maximum of nmc missed cleavages in a peptide. The
  // peptides are returned as a list of sequence position in the protein variable.

  // Forces size=0 in case previous positions were still in pept
  pept.resize(0);

  // Computes the position of peptides without missed cleavage
  int previous = 0;
  for (int i = 0; i < protein.length()-1; i++)
    if (((protein[i] == 'K') || (protein[i] == 'R')) && (protein[i+1] != 'P')){
      pept.push_back(PeptidePosition(previous, i, i-previous+1, 0));
      previous = i+1;
    }
  pept.push_back(PeptidePosition(previous, protein.length()-1, protein.length()-previous, 0));

  // Computes the position of peptides with up to nmc missed cleavages
  int numPept = pept.size();
  for (int i = 0; i < numPept-1; i++)
    for (int j = 1; (j <= nmc) && (i+j < numPept); j++)
      pept.push_back(PeptidePosition(pept[i].first, pept[i+j].last, pept[i+j].last-pept[i].first+1, j));

} // digestByTrypsin


void processFastaFile(const string fasta, int nmc, double minMass, double maxMass, double delta)
{
  // Digests all the proteins of a fasta file and collect the frequencies of peptide masses.

  // Vector for frequencies and digestion
  vector<PeptidePosition> pept;
  vector<int> freq;
  freq.assign(int((maxMass-minMass)/delta)+1, 0);

  // Processes the entire file of protein sequences
  string line, protein;
  ifstream fastaFile(fasta.c_str());
  getline(fastaFile, line); // Skips first fasta header
  while (fastaFile.good()){
    protein = "";
    do{
      getline(fastaFile, line);
      if (line[0] == '>')
	break;
      else
	protein += line;
    } while (fastaFile.good());

    // Digests and count
    digestByTrypsin(protein, nmc, pept);
    for (int i = 0; i < pept.size(); i++){
      double mass = getPeptideMass(protein, pept[i]);
      if ((mass >= minMass) && (mass <= maxMass))
	freq[int((mass-minMass)/delta)]++;
    }
  }

  // Prints the result on stdout
  for (int i = 0; i < freq.size(); i++)
    cout << minMass+i*delta << "\t" << freq[i] << endl;

} // processFastaFile


int main(int argc, char* argv[])
{
  string fasta;
  int nmc=1;
  double minMass=700, maxMass=3500, delta=0.05;

  readAAMasses("aamasses.txt", aaMasses, waterMass, protonMass);

  // Scans the command line
  for (int i = 1; i < argc; i++)
  {
    if ((strcmp(argv[i], "-fasta") == 0) && (i < argc-1))
      fasta = string(argv[++i]);
    else if ((strcmp(argv[i], "-nmc") == 0) && (i < argc-1))
      nmc = atoi(argv[++i]);
    else if ((strcmp(argv[i], "-minMass") == 0) && (i < argc-1))
      minMass = atof(argv[++i]);
    else if ((strcmp(argv[i], "-maxMass") == 0) && (i < argc-1))
      maxMass = atof(argv[++i]);
    else if ((strcmp(argv[i], "-delta") == 0) && (i < argc-1))
      delta = atof(argv[++i]);
  }

  // Digests everything
  processFastaFile(fasta, nmc, minMass, maxMass, delta);

  return 0;

} // main
