#include <stdio.h>
#include <stdlib.h>
#include "library.h"


struct Fiyat{
	
	char isim[20];
	float bir=1;
	float iki=4.5;
	float uc=2.25;
	float dort=3.75;
	float bes=2;
	float alti=5.50;
	float yedi=7.50;
	float sekiz=3.50;
	float dokuz=3;

};
typedef struct Fiyat Fiyat;

void goster(Fiyat a){
	printf(" 1-Su\n",a.isim);
	printf(" 2-Limonata\n",a.isim);
	printf(" 3-Gofret\n",a.isim);
	printf(" 4-Mentos\n",a.isim);
	printf(" 5-Pepsi\n",a.isim);
	printf(" 6-Nestle\n",a.isim);
	printf(" 7-Toblerone\n",a.isim);
	printf(" 8-Fanta\n",a.isim);
	printf(" 9-Brownie\n",a.isim);
}


float para1(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.bir;
	return sonuc;
}
float para2(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.iki;
	return sonuc;
}
float para3(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.uc;
	return sonuc;
}
float para4(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.dort;
	return sonuc;
}
float para5(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.bes;
	return sonuc;
}
float para6(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.alti;
	return sonuc;
}
float para7(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.yedi;
	return sonuc;
}
float para8(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.sekiz;
	return sonuc;
}
float para9(float girilen){
	float sonuc;
	Fiyat A;
	
	sonuc=girilen-A.dokuz;
	return sonuc;
}

