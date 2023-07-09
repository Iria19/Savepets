# -*- coding: utf-8 -*-

import csv
import random
import names
import numpy
import time

def random_with_N_digits(n):
    range_start = 10**(n-1)
    range_end = (10**n)-1
    return random.randint(range_start, range_end)

#Creo listas
length_of_string = 300
citylist=['Algeciras','Arcos de la Frontera','Cádiz','Chiclana de la Frontera','El Puerto de Santa María','Jerez de la Frontera','La Línea','Puerto Real','San Fernando','Sanlúcar de Barrameda','Córdoba','Bujalance','Cabra','Córdoba','Lucena','Montilla','Peñarroya-Pueblonuevo','Priego de Córdoba','Puente-Genil','Granada','Andújar','Baza','Granada','Guadix','Motril','Huelva','Huelva','Jaén','Jaén','Linares','Martos','Úbeda','Málaga','Antequera','Coín','Málaga','Melilla','Ronda','Sevilla','Alcalá de Guadaira','Carmona','Dos Hermanas','Ecija','Lebrija','Lora del Río','Marchena','Morón de la Frontera','Osuna','Sevilla','Utrera','Aragon','Huesca','Jaca','Teruel','Zaragoza','Asturias','Avilés','Cangas de Narcea','Gijón','Luarca','Mieres','Oviedo','Pola de Siero','San Martín del Rey Aurelio','Tineo','Villaviciosa','Balearic Islands','Palma','Maó','Basque Country','Álava','Vitoria-Gasteiz','Guipúzcoa','Donostia–San Sebastián','Eibar','Irun','Vizcaya','Barakaldo','Bilbao','Getxo','Guernica','Portugalete','Santurtzi','Sestao','Canary Islands','Las Palmas','Arucas','Las Palmas','Telde','Santa Cruz de Tenerife','La Orotava','Santa Cruz de Tenerife','Cantabria','Santander','Torrelavega','Castile–La Mancha','','Hellín','Villarrobledo','Ciudad Real','Alcázar de San Juan','Almadén','Ciudad Real','Puertollano','Tomelloso','Valdepeñas','Cuenca','Cuenca','Guadalajara','Guadalajara','Palencia','Salamanca','Ciudad Rodrigo','Salamanca','Segovia','San Ildefonso','Segovia','Soria','Soria','Valladolid','Simancas','Valladolid','Zamora','Toro','Zamora','Catalonia','Badalona','Barcelona','Cornellà','Granollers','L’Hospitalet de Llobregat','Manresa','Mataró','Reus','Sabadell','Santa Coloma de Gramenet','Terrassa','Vic','Vilanova i la Geltrú','Girona','Girona','Llívia','Lleida','Lleida','Tarragona','Tarragona','Tortosa','Ceuta (autonomous city)','Extremadura','Badajoz','Almendralejo','Badajoz','Don Benito','Mérida','Villanueva de la Serena','Cáceres','Alcántara','Cáceres','Guadalupe','Plasencia','Trujillo','Galicia','A Coruña','A Coruña','Carballo','Ferrol','Ortigueira','Ribeira','Santiago de Compostela','Lugo','Lugo','Mondoñedo','Monforte de Lemos','Vilalba','Ourense','Ourense','Vigo','Vilagarcía de Arousa','Pontevedra','Pontevedra','Madrid','Alcalá de Henares','Aranjuez','El Escorial','Getafe','Madrid','Melilla','Murcia','Caravaca','Cartagena','Cieza','Jumilla','Lorca','Murcia','Yecla','Navarra','Funes','Pamplona']
provincelist=['A Coruña','Alava','Albacete','Alicante','Almería','Asturias','Avila','Badajoz','Barcelona','Burgos','Cáceres','Cádiz','Cantabria','Castellón','Ceuta','Ciudad Real','Córdoba','Cuenca','Formentera','Girona','Granada','Guadalajara','Guipuzcoa','Huelva','Huesca','Ibiza','Jaén','La Rioja','Las Palmas de Gran Canaria','Gran Canaria','Fuerteventura','Lanzarote','León','Lérida','Lugo','Madrid','Málaga','Mallorca','Menorca','Murcia','Navarra','Orense','Palencia','Pontevedra','Salamanca','Santa Cruz de Tenerife','Tenerife','La Gomera','La Palma','El Hierro','Segovia','Sevilla','Soria','Tarragona','Teruel','Toledo','Valencia','Valladolid','Vizcaya','Zamora','Zaragoza']
specielist = ['cat','dog','bunny','hamster','snake','turtles','other']
otherspecielist = ['cat','dog','bunny','hamster','snake','turtles','other','several','']
chiplist = ['yes','no','unknown','']
sexlist = ['intact_female','intact_male','neutered_female','castrated_male','unknow']
racelistdog=['Affenpinscher','Airedale terrier','Akita','Akita americano','Alaskan Husky','Alaskan malamute','American Foxhound','American pit bull terrier','American staffordshire terrier','Ariegeois','Artois','Australian silky terrier','Australian Terrier','Austrian Black & Tan Hound','Azawakh','Balkan Hound','Basenji','Basset Alpino (Alpine Dachsbracke)','Basset Artesiano Normando','Basset Azul de Gascuña (Basset Bleu de Gascogne)','Basset de Artois','Basset de Westphalie','Basset Hound','Basset Leonado de Bretaña (Basset fauve de Bretagne)','Bavarian Mountain Scenthound','Beagle','Beagle Harrier','Beauceron','Bedlington Terrier','Bichon Boloñes','Bichón Frisé','Bichón Habanero','Billy','Black and Tan Coonhound','Bloodhound (Sabueso de San Huberto)','Bobtail','Boerboel','Border Collie','Border terrier','Borzoi','Bosnian Hound','Boston terrier','Bouvier des Flandres','Boxer','Boyero de Appenzell','Boyero de Australia','Boyero de Entlebuch','Boyero de las Ardenas','Boyero de Montaña Bernes','Braco Alemán de pelo corto','Braco Alemán de pelo duro','Braco de Ariege','Braco de Auvernia','Braco de Bourbonnais','Braco de Saint Germain','Braco Dupuy','Braco Francés','Braco Italiano','Broholmer','Buhund Noruego','Bull terrier','Bulldog americano','Bulldog inglés','Bulldog francés','Bullmastiff','Ca de Bestiar','Cairn terrier','Cane Corso','Cane da Pastore Maremmano-Abruzzese','Caniche (Poodle)','Caniche Toy (Toy Poodle)','Cao da Serra de Aires','Cao da Serra de Estrela','Cao de Castro Laboreiro','Cao de Fila de Sao Miguel','Cavalier King Charles Spaniel','Cesky Fousek','Cesky Terrier','Chesapeake Bay Retriever','Chihuahua','Chin','Chow Chow','Cirneco del Etna','Clumber Spaniel','Cocker Spaniel Americano','Cocker Spaniel Inglés','Collie Barbudo','Collie de Pelo Cort','Collie de Pelo Largo','Cotón de Tuléar','Curly Coated Retriever','Dálmata','Dandie dinmont terrier','Deerhound','Dobermann','Dogo Argentino','Dogo de Burdeos','Dogo del Tibet','Drentse Partridge Dog','Drever','Dunker','Elkhound Noruego','Elkhound Sueco','English Foxhound','English Springer Spaniel','English Toy Terrier','Epagneul Picard','Eurasier','Fila Brasileiro','Finnish Lapphound','Flat Coated Retriever','Fox terrier de pelo de alambre','Fox terrier de pelo liso','Foxhound Inglés','Frisian Pointer','Galgo Español','Galgo húngaro (Magyar Agar)','Galgo Italiano','Galgo Polaco (Chart Polski)','Glen of Imaal Terrier','Golden Retriever','Gordon Setter','Gos dAtura Catalá','Gran Basset Griffon Vendeano','Gran Boyero Suizo','Gran Danés (Dogo Aleman)','Gran Gascón Saintongeois','Gran Griffon Vendeano','Gran Munsterlander','Gran Perro Japonés','Grand Anglo Francais Tricoleur','Grand Bleu de Gascogne','Greyhound','Griffon Bleu de Gascogne','Griffon de pelo duro (Grifón Korthals)','Griffon leonado de Bretaña','Griffon Nivernais','Grifon Belga','Grifón de Bruselas','Haldenstoever','Harrier','Hokkaido','Hovawart','Husky Siberiano (Siberian Husky)','Ioujnorousskaia Ovtcharka','Irish Glen of Imaal terrier','Irish soft coated wheaten terrier','Irish terrier','Irish Water Spaniel','Irish Wolfhound','Jack Russell terrier','Jindo Coreano','Kai','Keeshond','Kelpie australiano (Australian kelpie)','Kerry blue terrier','King Charles Spaniel','Kishu','Komondor','Kooiker','Kromfohrländer','Kuvasz','Labrador Retriever','Lagotto Romagnolo','Laika de Siberia Occidental','Laika de Siberia Oriental','Laika Ruso Europeo','Lakeland terrier','Landseer','Lapphund Sueco','Lebrel Afgano','Lebrel Arabe (Sloughi)','Leonberger','Lhasa Apso','Lowchen (Pequeño Perro León)','Lundehund Noruego','Malamute de Alaska','Maltés','Manchester terrier','Mastiff','Mastín de los Pirineos','Mastín Español','Mastín Napolitano','Mudi','Norfolk terrier','Norwich terrier','Nova Scotia duck tolling retriever','Ovejero alemán','Otterhound','Rafeiro do Alentejo','Ratonero Bodeguero Andaluz','Retriever de Nueva Escocia','Rhodesian Ridgeback','Ridgeback de Tailandia','Rottweiler','Saarloos','Sabueso de Hamilton','Sabueso de Hannover','Sabueso de Hygen','Sabueso de Istria','Sabueso de Posavaz','Sabueso de Schiller (Schillerstovare)','Sabueso de Smaland (Smalandsstovare)','Sabueso de Transilvania','Sabueso del Tirol','Sabueso Español','Sabueso Estirio de pelo duro','Sabueso Finlandés','Sabueso Francés blanco y negro','Sabueso Francés tricolor','Sabueso Griego','Sabueso Polaco (Ogar Polski)','Sabueso Serbio','Sabueso Suizo','Sabueso Yugoslavo de Montaña','Sabueso Yugoslavo tricolor','Saluki','Samoyedo','San Bernardo','Sarplaninac','Schapendoes','Schipperke','Schnauzer estándar','Schnauzer gigante (Riesenschnauzer)','Schnauzer miniatura (Zwergschnauzer)','Scottish terrier','Sealyham terrier','Segugio Italiano','Seppala Siberiano','Setter Inglés','Setter Irlandés','Setter Irlandés rojo y blanco','Shar Pei','Shiba Inu','Shih Tzu','Shikoku','Skye terrier','Slovensky Cuvac','Slovensky Kopov','Smoushond Holandés','Spaniel Alemán (German Wachtelhund)','Spaniel Azul de Picardía','Spaniel Bretón','Spaniel de Campo','Spaniel de Pont Audemer','Spaniel Francés','Spaniel Tibetano','Spinone Italiano','Spítz Alemán','Spitz de Norbotten (Norbottenspets)','Spitz Finlandés','Spitz Japonés','Staffordshire bull terrier','Staffordshire terrier americano','Sussex Spaniel','Teckel (Dachshund)','Tchuvatch eslovaco','Terranova (Newfoundland)','Terrier australiano (Australian terrier)','Terrier brasilero','Terrier cazador alemán','Terrier checo (Ceský teriér)','Terrier galés','Terrier irlandés (Irish terrier)','Terrier japonés (Nihon teria)','Terrier negro ruso','Terrier tibetano','Tosa','Viejo Pastor Inglés','Viejo Pointer Danés (Old Danish Pointer)','Vizsla','Volpino Italiano','Weimaraner']
racelistcat=['Persa', 'Ruso azul', 'Bobtail americano', 'Somali', 'Siberiano', 'Ragdol', 'Maine coon', 'Manx','Birmano']
racelistbunny=['Blanco de Hotot', 'Rex','Cabeza de leon','Belier','English angora','Toy','Gigante de Flandes','Tan']
racelisthamster=['Ruso enano', 'Roborowski', 'Sirio','Chino', 'Enano de Campbell']
racelistsnake=[ 'Mamba','Boa','Víbora','Anaconda','Cobra','Serpiente de coral','Cabeza de cobre', 'Cascabel', 'Serpiente negra de vientre rojo','Culebra','Serpiente marrón oriental','Serpiente de Rata Negra','Pitón','Serpiente Mocasín de Agua', 'Pitón','Serpiente del maíz']
raceliststurtles=['Bosque','Rusa','Pintada','Orejas rojas','Caja de florida','Orejas amarillas','Cumberland','Mapa']
racelistsother=['Duroc','Alvera','Betizu','Pedresa']
statelist = ['healthy','sick','adopted','dead','foster','vet','unknown','other']
modellist=['Animal', 'PublicationAdoption','AnimalAdoption','AnimalShelter','Pages']
oficioslist=['Carpintero','Lechero','Frutero','Cerrajero','Cocinero','Secretaria','Mecánico','Lavandero','Artesano','Contador','Abogado','Médico cirujano','Paleontólogo','Ingeniero','Historiador','Geógrafo','Biólogo','Filólogo','Psicólogo','Matemático','Arquitecto','Computista','Profesor','Periodista','Botánico','Físico','Sociólogo','Farmacólogo','','Químico','Politólogo','Enfermero','Electricista','Bibliotecólogo','Paramédico','Técnico de sonido','Archivólogo','Músico','']
estudioslist=['Bellas artes','Ingeniería Informatica','ESO','Bachillerato','Magisterio','Criminología','Derecho','Ciencias políticas','Economía','Psicología','Sociología y antropología','Trabajo y atención social','Administración y gestión de empresas','Contabilidad y fiscalización','Finanzas, banca y seguros','Mercadotecnia y publicidad','Negocios y administración, programas multidisciplinarios o generales','Negocios y comercio','Ingeniería mecánica y metalurgia','Ingeniería química','Tecnología y protección del medio ambiente','Tecnologías de la información y comunicación']
estadocivillist=['single','married','divorced','separated','relationship','']
generelist=['male','female','nobinary','other','']
houselist=['detached house','semi-detached house','terraced house','bungalows','studio','apartment','flat','attic','ground floor','ground floor with garden','loft','duplex','triplex','quadplex','']
countrylist=['Argentina', 'Bolivia', 'Chile', 'Colombia', 'Costa Rica', 'Cuba', 'Republica Dominicana', 'Ecuador', 'El Salvador', 'Guinea Ecuatorial', 'Guatemala', 'Honduras', 'Mexico', 'Nicaragua', 'Panama', 'Paraguay', 'Peru', 'España', 'Uruguay','Venezuela','India','Pakistan','Singapur','Reino Unido', 'Republica de Irlanda', 'Malta','Francia','Alemania']


#Abro fichero
f = open('history.csv', 'a', newline='', encoding='utf-8')

writer = csv.writer(f, delimiter=',')

#Escribo en fichero
for x in range(5000):
    mymodellist=random.sample(modellist, k=1)[0]

    mypostalcode=random_with_N_digits(5)
    mymodellist=random.sample(modellist, k=1)[0]
    
    mycitylist=random.sample(citylist, k=1)[0]
    myprovincelist=random.sample(provincelist, k=1)[0]
    mycountry=random.sample(countrylist, k=1)[0]
    
    myusername=names.get_first_name()
    myage=random.randint(0, 100)
    mywork=random.sample(oficioslist, k=1)[0]
    mystudies=random.sample(estudioslist, k=1)[0]
    mymaritalstatus=random.sample(estadocivillist, k=1)[0]
    mygenere=random.sample(generelist, k=1)[0]
    mychildren=random.randint(0, 20)
    numpets=random.randint(0, 20)
    myotherspecielist=random.sample(otherspecielist, k=1)[0]
    myhouse=random.sample(houselist, k=1)[0]

    mypublicationadoption=random.randint(0, 2000)
    mypublicationhelp=random.randint(0, 2000)
    mypublicationstray=random.randint(0, 2000)
    mypublication=mypublicationadoption+mypublicationhelp+mypublicationstray
    mycomment=random.randint(0, 2000)
    if(numpets>0):
        myotherpets=random.sample(specielist, k=1)[0]
    if mymodellist != 'Pages':
        myspecielist=random.sample(specielist, k=1)[0]
        if(myspecielist=='dog'):
            myracelist=random.sample(racelistdog, k=1)[0]
        elif(myspecielist=='cat'):
            myracelist=random.sample(racelistcat, k=1)[0]
        elif(myspecielist=='bunny'):
            myracelist=random.sample(racelistbunny, k=1)[0]
        elif(myspecielist=='hamster'):
            myracelist=random.sample(racelisthamster, k=1)[0]
        elif(myspecielist=='snake'):
            myracelist=random.sample(racelistsnake, k=1)[0]
        elif(myspecielist=='turtles'):
            myracelist=random.sample(raceliststurtles, k=1)[0]      
        elif(myspecielist=='other'):
            myracelist=random.sample(racelistsother, k=1)[0]         

        myagelist = random.randint(0, 20)
        mychiplist=random.sample(chiplist, k=1)[0]   
        mysexlist=random.sample(sexlist, k=1)[0]   
        mystatelist=random.sample(statelist, k=1)[0]
        myanimalshelter= 'animalshelter'

    else:
        myagelist = 0
        myspecielist= ''  
        mychiplist= ''   
        mysexlist= ''  
        myracelist= ''
        mystatelist= ''
        myanimalshelter= ''

    array=numpy.array([mymodellist , myusername , mycountry , myprovincelist , mycitylist , mypostalcode ,mypublication,mypublicationadoption,mypublicationhelp,mypublicationstray,mycomment,myage,mywork,mystudies,mymaritalstatus,mychildren,myhouse,myotherspecielist,numpets,mygenere, myspecielist , mychiplist , mysexlist , myracelist , myagelist, mystatelist, myanimalshelter
])
    writer.writerow(array)
# Cierro fichero
f.close()
