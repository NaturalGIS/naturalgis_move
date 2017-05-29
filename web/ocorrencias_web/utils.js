var greenicon = L.icon({
    iconUrl: 'libs/leaflet/images/marker-icon-green.png',
    iconSize: [25, 40],
    iconAnchor: [12, 40],
    shadowSize: [40, 40]
});

var fileName;

jQuery(document).ready(function() {
	
    //TABS
    $('#form-tabs a').click(function (e){
        e.preventDefault();
        $(this).tab('show');
        if (this.innerHTML == 'Localização' && $('#map').hasClass('leaflet-container') == false){
            addMap();
        }
    });
    
    //OBSERVATION RADIOS
    $('#observation input[name="obs"]').click(function(){
        var radios = $('input[name="obs"]');
        for (var i = 0; i < radios.length; i++){
            if (radios[i].checked == true){
                if (radios[i].value == 'exacta'){
                    $('#aproximate-form').css('display', 'none');
                    $('#exact-form').css('display', 'inline');
                    
                    clearCombos(['sys_class', 'sys_class_val', 'phenology_aproximate', 'age_aproximate', 'sex_aproximate', 'behavior_aproximate']);
                    clearSpinners(['individuals_aproximate', 'individuals_type_aproximate']);
                } else {
                    $('#aproximate-form').css('display', 'inline');
                    $('#exact-form').css('display', 'none');
                    $('#sys_class_val').select2('enable', false);
                    $('#sys_class_val').select2('val', '');
                    $('#sys_class').select2('val', '');
                    clearCombos(['especie', 'phenology', 'age', 'sex', 'behavior']);
                    clearSpinners(['individuals', 'individuals_type']);
                }
            }
        }
    });
    
    //IDENTIFICATION FORM
    //especie old
//     $("#especie").select2({
//         placeholder: 'Espécie',
//         minimumInputLength: 3,
//         allowClear: true,
//         ajax: {
//             url: 'services/get_species.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     especie: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
//     
    //especie new
    var data = [{"id":482,"text":"Acanthodactylus erythrurus (Lagartixa-de-dedos-denteados)"},{"id":176,"text":"Accipiter gentilis (Açor)"},{"id":175,"text":"Accipiter nisus (Gavião da Europa)"},{"id":5031,"text":"Achondrostoma arcasii (Panjorca)"},{"id":5038,"text":"Achondrostoma occidentale (Ruivaco do Oeste)"},{"id":5039,"text":"Achondrostoma oligolepis (Ruivaco; Ruivaca; Robaco; Pardelha-de-escamas-grandes)"},{"id":5023,"text":"Acipenser sturio (Esturjão; Solho; Solho-rei)"},{"id":442,"text":"Acridotheres cristatellus (Mainá-de-crista)"},{"id":443,"text":"Acridotheres tristis (Mainá-indiano)"},{"id":399,"text":"Acrocephalus agricola (Felosa-agrícola)"},{"id":402,"text":"Acrocephalus arundinaceus (Rouxinol-grande-dos-caniços)"},{"id":396,"text":"Acrocephalus melanopogon (Felosa-real)"},{"id":397,"text":"Acrocephalus paludicola (Felosa-aquática)"},{"id":401,"text":"Acrocephalus palustris (Felosa-palustre)"},{"id":398,"text":"Acrocephalus schoenobaenus (Felosa-dos-juncos)"},{"id":400,"text":"Acrocephalus scirpaceus (Rouxinol-pequeno-dos-caniços)"},{"id":248,"text":"Actitis hypoleucos (Maçarico-das-rochas)"},{"id":249,"text":"Actitis macularia (Maçarico-maculado)"},{"id":424,"text":"Aegithalos caudatus (Chapim-rabilongo)"},{"id":169,"text":"Aegypius monachus (Abutre-preto)"},{"id":342,"text":"Alauda arvensis (Laverca)"},{"id":5001,"text":"Alburnus alburnus (Alburno)"},{"id":300,"text":"Alca torda (Torda-mergulheira)"},{"id":329,"text":"Alcedo atthis (Guarda-rios-comum)"},{"id":193,"text":"Alectoris rufa (Perdiz-comum)"},{"id":298,"text":"Alle alle (Torda-anã)"},{"id":5045,"text":"Alosa alosa (Sável)"},{"id":5044,"text":"Alosa fallax (Savelha; Saboga; Saveleta)"},{"id":513,"text":"Alytes cisternasii (Sapo-parteiro-ibérico)"},{"id":514,"text":"Alytes obstetricans (Sapo-parteiro-ibérico)"},{"id":452,"text":"Amandava amandava (Bengali-vermelho)"},{"id":5033,"text":"Ameiurus melas (Peixe-gato-negro)"},{"id":5043,"text":"Anaecypris hispanica (Saramugo; Pardelha; Bordalito)"},{"id":138,"text":"Anas acuta (Arrabio)"},{"id":134,"text":"Anas americana (Piadeira-americana)"},{"id":141,"text":"Anas clypeata (Pato-trombeteiro)"},{"id":136,"text":"Anas crecca (Marrequinha-comum)"},{"id":140,"text":"Anas discors (Pato-d'asa-azul)"},{"id":133,"text":"Anas penelope (Piadeira)"},{"id":137,"text":"Anas platyrhynchos (Pato-real)"},{"id":5070,"text":"Anas platyrhynchos domesticus (Pato)"},{"id":139,"text":"Anas querquedula (Marreco)"},{"id":135,"text":"Anas strepera (Frisada)"},{"id":5017,"text":"Anguilla anguilla (Enguia-europeia)"},{"id":494,"text":"Anguis fragilis (Cobra-de-vidro)"},{"id":126,"text":"Anser albifrons (Ganso-grande-de-testa-branca)"},{"id":127,"text":"Anser anser (Ganso-comum)"},{"id":125,"text":"Anser brachyrhynchus (Ganso-de-bico-curto)"},{"id":124,"text":"Anser fabalis (Ganso-campestre)"},{"id":351,"text":"Anthus campestris (Petinha-dos-campos)"},{"id":353,"text":"Anthus cervinus (Petinha-de-garganta-ruiva)"},{"id":350,"text":"Anthus godlewskii (Petinha-mongol)"},{"id":354,"text":"Anthus hodgsoni (Petinha-silvestre)"},{"id":357,"text":"Anthus petrosus (Petinha-marítima)"},{"id":352,"text":"Anthus pratensis (Petinha-dos-prados)"},{"id":349,"text":"Anthus richardi (Petinha de Richard)"},{"id":356,"text":"Anthus spinoletta (Petinha-ribeirinha)"},{"id":355,"text":"Anthus trivialis (Petinha-das-árvores)"},{"id":81,"text":"Apodemus flavicolis (Rato-de-colar)"},{"id":63,"text":"Apodemus sylvaticus (Rato-do-campo)"},{"id":327,"text":"Apus affinis (Andorinhão-pequeno)"},{"id":325,"text":"Apus apus (Andorinhão-preto)"},{"id":328,"text":"Apus caffer (Andorinhão-cafre)"},{"id":326,"text":"Apus pallidus (Andorinhão-pálido)"},{"id":181,"text":"Aquila adalberti (Águia-imperial-ibérica)"},{"id":182,"text":"Aquila chrysaetos (Águia-real)"},{"id":180,"text":"Aquila clanga (Águia-gritadeira)"},{"id":179,"text":"Aquila pomarina (Águia-pomarina)"},{"id":311,"text":"Aratinga acuticaudata (Periquitão-de-cabeça-azul)"},{"id":106,"text":"Ardea cinerea (Garça-real)"},{"id":107,"text":"Ardea purpurea (Garça-roxa)"},{"id":111,"text":"Ardeola ralloides (Papa-ratos)"},{"id":250,"text":"Arenaria interpres (Rola-do-mar)"},{"id":64,"text":"Arvicola sapidus (Rata-de-agua)"},{"id":65,"text":"Arvicola terrestris (Rato-dos-lameiros)"},{"id":321,"text":"Asio flammeus (Coruja-do-nabal)"},{"id":320,"text":"Asio otus (Bufo-pequeno)"},{"id":319,"text":"Athene noctua (Mocho-galego)"},{"id":5034,"text":"Atherina boyeri (Peixe-rei; Peixe-rei-do-Mediterrâneo; Verdugo; Piarda)"},{"id":5015,"text":"Australoheros facetus (Chanchito; Espanhol; Castanhola; Castanheta)"},{"id":149,"text":"Aythya affinis (Negrelho-americano)"},{"id":145,"text":"Aythya collaris (Zarro-de-colar)"},{"id":144,"text":"Aythya ferina (Zarro-comum)"},{"id":147,"text":"Aythya fuligula (Zarro-negrinha)"},{"id":148,"text":"Aythya marila (Zarro-bastardo)"},{"id":146,"text":"Aythya nyroca (Zarro-castanho)"},{"id":27,"text":"Barbastella barbastellus (Morcego-negro)"},{"id":237,"text":"Bartramia longicauda (Maçarico-do-campo)"},{"id":495,"text":"Blanus cinereus (Cobra-cega)"},{"id":114,"text":"Botaurus stellaris (Abetouro-comum)"},{"id":130,"text":"Branta bernicla (Ganso-de-faces-negras)"},{"id":128,"text":"Branta canadensis (Ganso do Canadá)"},{"id":129,"text":"Branta leucopsis (Ganso-de-faces-brancas)"},{"id":317,"text":"Bubo bubo (Bufo-real)"},{"id":110,"text":"Bubulcus ibis (Garca-vaqueira)"},{"id":154,"text":"Bucephala clangula (Pato-olho-d'ouro)"},{"id":518,"text":"Bufo spinosus (Sapo-comum)"},{"id":92,"text":"Bulweria bulwerii (Alma-negra)"},{"id":214,"text":"Burhinus oedicnemus (Alcaravão)"},{"id":177,"text":"Buteo buteo (Águia-d'asa-redonda)"},{"id":178,"text":"Buteo rufinus (Búteo-mouro)"},{"id":338,"text":"Calandrella brachydactyla (Calhandrinha-comum)"},{"id":339,"text":"Calandrella rufescens (Calhandrinha-das-marismas)"},{"id":252,"text":"Calidris alba (Pilrito-sanderlingo)"},{"id":263,"text":"Calidris alpina (Pilrito-comum)"},{"id":259,"text":"Calidris bairdii (Pilrito de Baird)"},{"id":251,"text":"Calidris canutus (Seixoeira)"},{"id":261,"text":"Calidris ferruginea (Pilrito-de-bico-comprido)"},{"id":258,"text":"Calidris fuscicollis (Macarico de rabadilha branca)"},{"id":262,"text":"Calidris maritima (Pilrito-escuro)"},{"id":254,"text":"Calidris mauri (Pilrito de Maur)"},{"id":260,"text":"Calidris melanotos (Pilrito-peitoral)"},{"id":255,"text":"Calidris minuta (Pilrito-pequeno)"},{"id":257,"text":"Calidris minutilla (Pilrito-anão)"},{"id":253,"text":"Calidris pusilla (Pilrito-semipalmado)"},{"id":256,"text":"Calidris temminckii (Pilrito de Temminck)"},{"id":93,"text":"Calonectris diomedea (Cagarra)"},{"id":7,"text":"Canis lupus (Lobo)"},{"id":5064,"text":"Canis lupus familiaris (Cão)"},{"id":5067,"text":"Capra aegagrus hircus (Capra)"},{"id":1,"text":"Capra pyrenaica (Cabra-montês)"},{"id":3,"text":"Capreolus capreolus (Corço)"},{"id":323,"text":"Caprimulgus europaeus (Noitibó da Europa)"},{"id":322,"text":"Caprimulgus ruficollis (Noitibó-de-nuca-vermelha)"},{"id":5037,"text":"Carassius auratus (Pimpão; Peixe-vermelho; Peixe-dourado; Carpa-dourada)"},{"id":461,"text":"Carduelis cannabina (Pintarroxo-comum)"},{"id":460,"text":"Carduelis carduelis (Pintassilgo)"},{"id":458,"text":"Carduelis chloris (Verdilhão-comum)"},{"id":459,"text":"Carduelis spinus (Lugre)"},{"id":269,"text":"Catharacta skua (Moleiro-grande)"},{"id":348,"text":"Cecropis daurica (Andorinha-dáurica)"},{"id":427,"text":"Certhia brachydactyla (Trepadeira-comum)"},{"id":4,"text":"Cervus elaphus (Veado)"},{"id":393,"text":"Cettia cetti (Rouxinol-bravo)"},{"id":480,"text":"Chalcides bedriagai (Fura-pastos-pentadáctilo)"},{"id":481,"text":"Chalcides striatus (Fura-pastos-tridáctilo-ibérico)"},{"id":477,"text":"Chamaeleo chamaeleon (Camaleão)"},{"id":225,"text":"Charadrius alexandrinus (Borrelho-de-coleira-interrompida)"},{"id":224,"text":"Charadrius dubius (Borrelho-pequeno-de-coleira)"},{"id":223,"text":"Charadrius hiaticula (Borrelho-grande-de-coleira)"},{"id":226,"text":"Charadrius morinellus (Borrelho-ruivo)"},{"id":506,"text":"Chioglossa lusitanica (Salamandra-lusitânica)"},{"id":78,"text":"Chionomys nivalis (Rato-das-neves)"},{"id":295,"text":"Chlidonias hybridus (Gaivina-de-faces-brancas)"},{"id":296,"text":"Chlidonias leucopterus (Gaivina-d'asa-branca)"},{"id":297,"text":"Chlidonias niger (Gaivina-preta)"},{"id":116,"text":"Ciconia ciconia (Cegonha-branca)"},{"id":115,"text":"Ciconia nigra (Cegonha-preta)"},{"id":362,"text":"Cinclus cinclus (Melro-d'água)"},{"id":170,"text":"Circaetus gallicus (Águia-cobreira)"},{"id":171,"text":"Circus aeruginosus (Tartaranhão-ruivo-dos-pauis)"},{"id":172,"text":"Circus cyaneus (Tartaranhão-azulado)"},{"id":173,"text":"Circus macrourus (Tartaranhão-de-peito-branco)"},{"id":174,"text":"Circus pygargus (Tartaranhão-caçador)"},{"id":392,"text":"Cisticola juncidis (Fuinha-dos-juncos)"},{"id":313,"text":"Clamator glandarius (Cuco-rabilongo)"},{"id":151,"text":"Clangula hyemalis (Pato-de-cauda-afilada)"},{"id":5050,"text":"Cobitis calderoni (Verdemã do Norte; Peixe-rei)"},{"id":5051,"text":"Cobitis paludica (Verdemã-comum; Peixe-rei; Serpentina)"},{"id":464,"text":"Coccothraustes coccothraustes (Bico-grossudo)"},{"id":304,"text":"Columba livia (Pombo-doméstico)"},{"id":305,"text":"Columba oenas (Pombo-bravo)"},{"id":306,"text":"Columba palumbus (Pombo-torcaz)"},{"id":331,"text":"Coracias garrulus (Rolieiro-comum)"},{"id":497,"text":"Coronella austriaca (Cobra-lisa)"},{"id":498,"text":"Coronella girondica (Cobra-lisa-bordalesa)"},{"id":438,"text":"Corvus corax (Corvo)"},{"id":437,"text":"Corvus corone (Gralha-preta)"},{"id":436,"text":"Corvus monedula (Gralha-de-nuca-cinzenta)"},{"id":195,"text":"Coturnix coturnix (Codorniz)"},{"id":200,"text":"Crex crex (Codornizão)"},{"id":52,"text":"Crocidura russula (Musaranho-de-dentes-brancos)"},{"id":53,"text":"Crocidura suaveolens (Musaranho-de-dentes-brancos-pequenos)"},{"id":314,"text":"Cuculus canorus (Cuco-canoro)"},{"id":215,"text":"Cursorius cursor (Corredor)"},{"id":421,"text":"Cyanistes caeruleus (Chapim-azul)"},{"id":433,"text":"Cyanopica cooki (Pega-azul)"},{"id":123,"text":"Cygnus cygnus (Cisne-bravo)"},{"id":122,"text":"Cygnus olor (Cisne-vulgar)"},{"id":5014,"text":"Cyprinus carpio (Carpa; Sarmão)"},{"id":5,"text":"Dama dama (Gamo)"},{"id":347,"text":"Delichon urbicum (Andorinho-dos-beirais)"},{"id":335,"text":"Dendrocopos major (Pica-pau-malhado-grande)"},{"id":334,"text":"Dendrocopos minor (Pica-pau-malhado-pequeno)"},{"id":515,"text":"Discoglossus galganoi (Rã-de-focinho-ponteagudo)"},{"id":108,"text":"Egretta alba (Garça-branca-grande)"},{"id":109,"text":"Egretta garzetta (Garça-branca-pequena)"},{"id":161,"text":"Elanus caeruleus (Peneireiro-cinzento)"},{"id":62,"text":"Eliomys quercinus (Leirão)"},{"id":466,"text":"Emberiza calandra (Trigueirão)"},{"id":468,"text":"Emberiza cia (Cia)"},{"id":470,"text":"Emberiza cirlus (Escrevedeira-de-garganta-preta)"},{"id":467,"text":"Emberiza citrinella (Escrevedeira-amarela)"},{"id":469,"text":"Emberiza hortulana (Sombria)"},{"id":471,"text":"Emberiza pusilla (Escrevedeira-pigmeia)"},{"id":472,"text":"Emberiza rustica (Escrevedeira-rústica)"},{"id":473,"text":"Emberiza schoeniclus (Escrevedeira-dos-caniços)"},{"id":474,"text":"Emys orbicularis (Cágado-de-carapaça-estriada)"},{"id":519,"text":"Epidalea calamita (Sapo-corredor)"},{"id":50,"text":"Eptesicus isabellinus (-)"},{"id":28,"text":"Eptesicus serotinus (Morcego-hortelão)"},{"id":5066,"text":"Equus caballus (Cavalo)"},{"id":51,"text":"Erinaceus europaeus (Ouriço-cacheiro)"},{"id":376,"text":"Erithacus rubecula (Pisco-de-peito-ruivo)"},{"id":377,"text":"Erythropygia galactotes (Rouxinol-do-mato)"},{"id":5029,"text":"Esox lucius (Lúcio)"},{"id":453,"text":"Estrilda astrild (Bico-de-lacre)"},{"id":449,"text":"Euplectes afer (Bispo-de-coroa-amarela)"},{"id":191,"text":"Falco biarmicus (Alfaneque)"},{"id":189,"text":"Falco columbarius (Esmerilhão)"},{"id":188,"text":"Falco eleonorae (Falcão-da-rainha)"},{"id":185,"text":"Falco naumanni (Peneireiro-das-torres)"},{"id":192,"text":"Falco peregrinus (falcão-peregrino)"},{"id":190,"text":"Falco subbuteo (Ógea)"},{"id":186,"text":"Falco tinnunculus (Peneireiro-vulgar)"},{"id":187,"text":"Falco vespertinus (Falcão-de-pés-vermelhos)"},{"id":9,"text":"Felis silvestris (Gato-bravo)"},{"id":5065,"text":"Felis silvestris catus (Gato-doméstico)"},{"id":388,"text":"Ficedula hypoleuca (Papa-moscas-preto)"},{"id":389,"text":"Ficedula parva (Papa-moscas-pequeno)"},{"id":301,"text":"Fratercula arctica (Papagaio-do-mar)"},{"id":455,"text":"Fringilla coelebs (Tentilhão-comum)"},{"id":456,"text":"Fringilla montifringilla (Tentilhão-montês)"},{"id":208,"text":"Fulica americana (Galeirão-americano)"},{"id":207,"text":"Fulica atra (Galeirão-comum)"},{"id":206,"text":"Fulica cristata (Galeirão-de-crista)"},{"id":58,"text":"Galemys pyrenaicus (Toupeira-de-água)"},{"id":340,"text":"Galerida cristata (Cotovia-de-poupa)"},{"id":341,"text":"Galerida theklae (Cotovia-montesina)"},{"id":230,"text":"Gallinago gallinago (Narceja-comum)"},{"id":229,"text":"Gallinago media (Narceja-real)"},{"id":205,"text":"Gallinula chloropus (Galinha-d'água)"},{"id":5069,"text":"Gallus gallus domesticus (Galo)"},{"id":5024,"text":"Gambusia holbrooki (Gambúsia; Gambusino; Peixe-mosquito; Peixe-sapo)"},{"id":432,"text":"Garrulus glandarius (Gaio-comum)"},{"id":5022,"text":"Gasterosteus aculeatus (Esgana-gata; Peixe-espinho)"},{"id":84,"text":"Gavia arctica (Mobêlha-árctica)"},{"id":85,"text":"Gavia immer (Mobêlha-grande)"},{"id":83,"text":"Gavia stellata (Mobêlha-pequena)"},{"id":288,"text":"Gelochelidon nilotica (Gaivina-de-bico-preto)"},{"id":19,"text":"Genetta genetta (Geneta)"},{"id":118,"text":"Geronticus eremita (Íbis-calva)"},{"id":216,"text":"Glareola pratincola (Perdiz-do-mar)"},{"id":77,"text":"Glis glis (Leirão cinzento)"},{"id":5025,"text":"Gobio lozanoi (Gobio)"},{"id":198,"text":"Grus grus (Grou-comum)"},{"id":164,"text":"Gypaetus barbatus (Quebra-ossos)"},{"id":166,"text":"Gyps africanus (Grifo do cabo)"},{"id":168,"text":"Gyps fulvus (Grifo-comum)"},{"id":167,"text":"Gyps rueppellii (Grifo de Rüppell)"},{"id":211,"text":"Haematopus ostralegus (Ostraceiro)"},{"id":478,"text":"Hemidactylus turcicus (Osga-turca)"},{"id":496,"text":"Hemorrhois hippocrepis (Cobra-de-ferradura)"},{"id":20,"text":"Herpestes ichneumon (Sacarrabos)"},{"id":183,"text":"Hieraaetus fasciatus (Águia de Bonelli)"},{"id":184,"text":"Hieraaetus pennatus (Águia-calçada)"},{"id":212,"text":"Himantopus himantopus (pernilongo-de-costas-negras)"},{"id":405,"text":"Hippolais icterina (Felosa-icterina)"},{"id":403,"text":"Hippolais opaca (Felosa-palida)"},{"id":404,"text":"Hippolais polyglotta (Felosa-poliglota)"},{"id":345,"text":"Hirundo rustica (Andorinha-das-chaminés)"},{"id":100,"text":"Hydrobates pelagicus (Paínho-de-cauda-quadrada)"},{"id":289,"text":"Hydroprogne caspia (Gaivina-de-bico-vermelho)"},{"id":521,"text":"Hyla meridionalis (Rela-meridional)"},{"id":520,"text":"Hyla molleri (Rela)"},{"id":29,"text":"Hypsugo savii (Morcego de Savi)"},{"id":5008,"text":"Iberochondrostoma almacai (Boga do Sudoeste; Pardelha-do-mira; Boga)"},{"id":5010,"text":"Iberochondrostoma lemmingii (Boga-de-boca-arqueada; Pardelha; Ruivaca)"},{"id":5011,"text":"Iberochondrostoma lusitanicum (Boga-portuguesa; Pardelha)"},{"id":483,"text":"Iberolacerta monticola (Lagartixa-da-montanha)"},{"id":113,"text":"Ixobrychus minutus (Garça-pequena)"},{"id":333,"text":"Jynx torquilla (Torcicolo)"},{"id":484,"text":"Lacerta schreiberi (Lagarto-de-água)"},{"id":5027,"text":"Lampetra fluviatilis (Lampreia-de-rio)"},{"id":5026,"text":"Lampetra planeri (Lampreia-de-riacho; Lampreia-pequena)"},{"id":429,"text":"Lanius collurio (Picanço-de-dorso-ruivo)"},{"id":430,"text":"Lanius meridionalis (Picanço-real)"},{"id":431,"text":"Lanius senator (Picanço-barreteiro)"},{"id":279,"text":"Larus argentatus (Gaivota-argêntea)"},{"id":274,"text":"Larus audouinii (Gaivota de Audouin)"},{"id":273,"text":"Larus canus (Gaivota-parda)"},{"id":275,"text":"Larus delawarensis (Gaivota de Delaware)"},{"id":281,"text":"Larus fuscus (Gaivota-d'asa-escura)"},{"id":283,"text":"Larus genei (Gaivota-de-bico-fino)"},{"id":278,"text":"Larus glaucoides (Gaivota-polar)"},{"id":277,"text":"Larus hyperboreus (Gaivota-hiperbórea)"},{"id":276,"text":"Larus marinus (Alcatraz-comum)"},{"id":284,"text":"Larus melanocephalus (Gaivota-de-cabeça-preta)"},{"id":280,"text":"Larus michahellis (Gaivota-de-patas-amarelas)"},{"id":285,"text":"Larus minutus (Gaivota-pequena)"},{"id":282,"text":"Larus ridibundus (Guincho-comum)"},{"id":5036,"text":"Lepomis gibbosus (Perca-sol; Peixe-sol)"},{"id":60,"text":"Lepus granatensis (Lebre)"},{"id":264,"text":"Limicola falcinellus (Pilrito-falcinelo)"},{"id":231,"text":"Limnodromus griseus (Maçarico-de-costa-branca)"},{"id":232,"text":"Limnodromus scolopaceus (Maçarico-escolopáceo-americano)"},{"id":234,"text":"Limosa lapponica (Fuselo)"},{"id":233,"text":"Limosa limosa (Maçarico-de-bico-direito)"},{"id":511,"text":"Lissotriton boscai (Tritão-de-ventre-laranja)"},{"id":512,"text":"Lissotriton helveticus (Tritão-palmado)"},{"id":5046,"text":"Liza aurata (Tainha-garrento; Tainha amarela)"},{"id":5030,"text":"Liza ramada (Taínha-fataça; Muge; Alvor; Bicudo; Corveu; Fataça-do-ribatejo; Moleca; Mugem; Oirives)"},{"id":395,"text":"Locustella luscinioides (Felosa-unicolor)"},{"id":394,"text":"Locustella naevia (Felosa-malhada)"},{"id":454,"text":"Lonchura atricapilla (Bico-de-chumbo-de-cabeça-negra)"},{"id":419,"text":"Lophophanes cristatus (Chapim-de-poupa)"},{"id":462,"text":"Loxia curvirostra (Cruza-bico)"},{"id":5004,"text":"Luciobarbus bocagei (Barbo-comum; Barbo do Norte)"},{"id":5016,"text":"Luciobarbus comizo (Cumba; Barbo-focinheiro; Trompeteiro; Picão; Judeu)"},{"id":5005,"text":"Luciobarbus microcephalus (Barbo-de-cabeça-pequena)"},{"id":5003,"text":"Luciobarbus sclateri (Barbo do Sul; Barbo-do-Algarve; Barbo-gitano; Barbo-cigano)"},{"id":5002,"text":"Luciobarbus steindachneri (Barbo de Steindachner; Barbo-intermédio)"},{"id":343,"text":"Lullula arborea (Cotovia-pequena)"},{"id":374,"text":"Luscinia megarhynchos (Rouxinol-comum)"},{"id":375,"text":"Luscinia svecica (Pisco-de-peito-azul)"},{"id":11,"text":"Lutra lutra (Lontra)"},{"id":228,"text":"Lymnocryptes minimus (Narceja-galega)"},{"id":10,"text":"Lynx pardinus (Lince-iberico)"},{"id":499,"text":"Macroprotodon brevis (Cobra-de-capuz)"},{"id":500,"text":"Malpolon monspessulanus (Cobra-rateira)"},{"id":142,"text":"Marmaronetta angustirostris (Pardilheira)"},{"id":76,"text":"Marmota marmota (Marmota-alpina)"},{"id":12,"text":"Martes foina (Fuinha)"},{"id":13,"text":"Martes martes (Marta)"},{"id":476,"text":"Mauremys leprosa (Cágado-comum)"},{"id":153,"text":"Melanitta fusca (Pato-fusco)"},{"id":152,"text":"Melanitta nigra (Pato-preto)"},{"id":337,"text":"Melanocorypha calandra (Calhandra-comum)"},{"id":14,"text":"Meles meles (Texugo)"},{"id":156,"text":"Mergus merganser (Merganso-grande)"},{"id":155,"text":"Mergus serrator (Merganso-de-poupa)"},{"id":330,"text":"Merops apiaster (Abelharuco-comum)"},{"id":5000,"text":"Micropterus salmoides (Achigã)"},{"id":66,"text":"Microtus agrestis (Rato-do-campo-de-rabo-curto)"},{"id":67,"text":"Microtus arvalis (-)"},{"id":68,"text":"Microtus cabrerae (Rato de Cabrera)"},{"id":69,"text":"Microtus duodecimcostatus (Rato-cego-mediterranico)"},{"id":70,"text":"Microtus lusitanicus (Rato-cego)"},{"id":163,"text":"Milvus migrans (Milhafre-preto)"},{"id":162,"text":"Milvus milvus (Milhafre-real)"},{"id":21,"text":"Miniopterus schreibersii (Morcego-de-peluche)"},{"id":372,"text":"Monticola saxatilis (Melro-das-rochas)"},{"id":373,"text":"Monticola solitarius (Melro-azul)"},{"id":448,"text":"Montifringilla nivalis (Pardal-alpino)"},{"id":358,"text":"Motacilla alba (Alvéola-branca)"},{"id":361,"text":"Motacilla cinerea (Alvéola-cinzenta)"},{"id":360,"text":"Motacilla citreola (Alvéola-citrina)"},{"id":359,"text":"Motacilla flava (Alvéola-amarela)"},{"id":387,"text":"Muscicapa striata (Papa-moscas-cinzento)"},{"id":71,"text":"Mus domesticus (Rato-caseiro)"},{"id":72,"text":"Mus spretus (Rato-das-hortas)"},{"id":15,"text":"Mustela erminea (Arminho)"},{"id":16,"text":"Mustela nivalis (Doninha)"},{"id":17,"text":"Mustela putorius (Toirão)"},{"id":18,"text":"Mustela vison (Visão-americano)"},{"id":80,"text":"Mycromys minutus (-)"},{"id":312,"text":"Myiopsitta monachus (Caturrita)"},{"id":82,"text":"Myocastor coipus (-)"},{"id":30,"text":"Myotis bechsteini (Morcego de Bechstein)"},{"id":31,"text":"Myotis blythii (Morcego-rato-pequeno)"},{"id":32,"text":"Myotis daubentonii (Morcego-de-água)"},{"id":33,"text":"Myotis emarginatus (Morcego-lanudo)"},{"id":49,"text":"Myotis escalerai (-)"},{"id":34,"text":"Myotis myotis (Morcego-rato-grande)"},{"id":35,"text":"Myotis mystacinus (Morcego-de-bigodes)"},{"id":36,"text":"Myotis nattereri (Morcego-de-franja)"},{"id":502,"text":"Natrix astreptophora (Cobra-de-água-de-colar)"},{"id":501,"text":"Natrix maura (Cobra-de-água-viperina)"},{"id":54,"text":"Neomys anomalus (Musaranho-de-agua)"},{"id":165,"text":"Neophron percnopterus (Abutre do Egipto)"},{"id":143,"text":"Netta rufina (Pato-de-bico-vermelho)"},{"id":236,"text":"Numenius arquata (Maçarico-real)"},{"id":235,"text":"Numenius phaeopus (Maçarico-galego)"},{"id":37,"text":"Nyctalus azoreum (Morcego dos Açores)"},{"id":38,"text":"Nyctalus lasiopterus (Morcego-arboricola-gigante)"},{"id":39,"text":"Nyctalus leisleri (Morcego-arboricola-pequeno)"},{"id":40,"text":"Nyctalus noctula (Morcego-arboricola-grande)"},{"id":112,"text":"Nycticorax nycticorax (Socó-taquari)"},{"id":99,"text":"Oceanites oceanicus (Painho de Wilson)"},{"id":101,"text":"Oceanodroma castro (Painho-da-ilha-da-madeira)"},{"id":102,"text":"Oceanodroma leucorhoa (Painho-de-cauda-forcada)"},{"id":385,"text":"Oenanthe deserti (Chasco-do-deserto)"},{"id":384,"text":"Oenanthe hispanica (Chasco-ruivo)"},{"id":386,"text":"Oenanthe isabellina (Chasco-isabel)"},{"id":382,"text":"Oenanthe leucura (Chasco-preto)"},{"id":383,"text":"Oenanthe oenanthe (Chasco-cinzento)"},{"id":5048,"text":"Oncorhynchus mykiss (Truta-arco-iris)"},{"id":79,"text":"Ondatra zibethicus (-)"},{"id":428,"text":"Oriolus oriolus (Papa-figos)"},{"id":61,"text":"Oryctolagus cuniculus (Coelho-bravo)"},{"id":209,"text":"Otis tarda (Abetarda-comum)"},{"id":316,"text":"Otus scops (Mocho-d'orelhas)"},{"id":2,"text":"Ovis ammon (Muflão)"},{"id":157,"text":"Oxyura jamaicensis (Pato-rabo-alçado-americano)"},{"id":158,"text":"Oxyura leucocephala (Pato-de-rabo-alçado)"},{"id":159,"text":"Pandion haliaetus (Águia-pesqueira)"},{"id":420,"text":"Parus major (Chapim-real)"},{"id":444,"text":"Passer domesticus (Pardal-comum)"},{"id":445,"text":"Passer hispaniolensis (Pardal-espanhol)"},{"id":446,"text":"Passer montanus (Pardal-montez)"},{"id":441,"text":"Pastor roseus (Estorinho-rosado)"},{"id":5071,"text":"Pelobates cultripes (Sapo-de-unha-negra)"},{"id":517,"text":"Pelodytes ibericus (Sapo-de-verrugas-verdes-ibérico)"},{"id":516,"text":"Pelodytes punctatus (Sapo-de-verrugas-verdes)"},{"id":523,"text":"Pelophylax perezi (Rã-verde)"},{"id":5035,"text":"Perca fluviatilis (Perca; Perca-europeia)"},{"id":194,"text":"Perdix perdix (Perdiz-cinzenta)"},{"id":422,"text":"Periparus ater (Chapim-carvoeiro)"},{"id":160,"text":"Pernis apivorus (Bútio-vespeiro)"},{"id":5028,"text":"Petromyzon marinus (Lampreia-marinha; Lampreia-do-mar)"},{"id":447,"text":"Petronia petronia (Pardal-francês)"},{"id":105,"text":"Phalacrocorax aristotelis (Corvo-marinho-de-crista)"},{"id":104,"text":"Phalacrocorax carbo (Corvo-marinho-de-faces-brancas)"},{"id":268,"text":"Phalaropus fulicaria (Falaropo-de-bico-grosso)"},{"id":267,"text":"Phalaropus lobatus (Falaropo-de-bico-fino)"},{"id":196,"text":"Phasianus colchicus (Faisão)"},{"id":266,"text":"Philomachus pugnax (Combatente)"},{"id":121,"text":"Phoenicopterus ruber (Flamingo-comum)"},{"id":378,"text":"Phoenicurus ochruros (Rabirruivo-preto)"},{"id":379,"text":"Phoenicurus phoenicurus (Rabirruivo-de-testa-branca)"},{"id":409,"text":"Phylloscopus bonelli (Felosa de Bonelli)"},{"id":407,"text":"Phylloscopus collybita (Felosa-comum)"},{"id":408,"text":"Phylloscopus ibericus (Felosa-ibérica)"},{"id":410,"text":"Phylloscopus sibilatrix (Felosa-assobiadeira)"},{"id":406,"text":"Phylloscopus trochilus (Felosa-musical)"},{"id":434,"text":"Pica pica (Pega-rabuda)"},{"id":336,"text":"Picus viridis (Pica-pau-verde)"},{"id":41,"text":"Pipistrellus kuhli (Morcego de Kuhl)"},{"id":42,"text":"Pipistrellus maderensis (Morcego da Madeira)"},{"id":43,"text":"Pipistrellus nauthusii (Morcego de Nathusius)"},{"id":44,"text":"Pipistrellus pipistrellus (Morcego-anão)"},{"id":45,"text":"Pipistrellus pygmaeus (Morcego-pigmeu)"},{"id":46,"text":"Pipistrellus savii (Morcego de Savi)"},{"id":120,"text":"Platalea leucorodia (Colhereiro)"},{"id":47,"text":"Plecotus auritus (Morcego-orelhudo-castanho)"},{"id":48,"text":"Plecotus austriacus (Morcego-orelhudo-cinzento)"},{"id":465,"text":"Plectrophenax nivalis (Escrevedeira-das-neves)"},{"id":119,"text":"Plegadis falcinellus (Íbis-preta)"},{"id":507,"text":"Pleurodeles waltl (Salamadra-de-costelas-salientes)"},{"id":451,"text":"Ploceus cucullatus (Cacho-caldeirão)"},{"id":450,"text":"Ploceus melanocephalus (Tecelão-de-cabeça-preta)"},{"id":219,"text":"Pluvialis apricaria (Tarambola-dourada)"},{"id":221,"text":"Pluvialis dominica (Tarambola-dourada-pequena)"},{"id":220,"text":"Pluvialis fulva (Batuirucu)"},{"id":222,"text":"Pluvialis squatarola (Tarambola-cinzenta)"},{"id":489,"text":"Podarcis bocagei (Lagartixa de Bocage)"},{"id":490,"text":"Podarcis carbonelli (Lagartixa de Carbonell)"},{"id":493,"text":"Podarcis sicula (Lagartixa-italiana)"},{"id":492,"text":"Podarcis vaucheri (-)"},{"id":491,"text":"Podarcis virescens (Lagartixa-ibérica)"},{"id":88,"text":"Podiceps auritus (Mergulhão-de-pescoço-castanho)"},{"id":87,"text":"Podiceps cristatus (Mergulhão-de-crista)"},{"id":89,"text":"Podiceps nigricollis (Mergulhão-de-pescoço-preto)"},{"id":310,"text":"Poicephalus senegalus (Papagaio do Senegal)"},{"id":204,"text":"Porphyrio porphyrio (Caimão)"},{"id":201,"text":"Porzana parva (Franga-d'água-bastarda)"},{"id":203,"text":"Porzana porzana (Franga-d'água-grande)"},{"id":202,"text":"Porzana pusilla (Franga-d'água-pequena)"},{"id":364,"text":"Prunella collaris (Ferreirinha-alpina)"},{"id":365,"text":"Prunella modularis (Ferreirinha-comum)"},{"id":487,"text":"Psammodromus algirus (Lagartixa-do-mato)"},{"id":488,"text":"Psammodromus occidentalis (Lagartixa-do-mato-ibérica)"},{"id":5006,"text":"Pseudochondrostoma duriense (Boga do Douro; Boga do Norte)"},{"id":5009,"text":"Pseudochondrostoma polylepis (Boga-comum; Boga-de-boca-recta)"},{"id":5007,"text":"Pseudochondrostoma willkommii (Boga do Guadiana; Boga do Sul)"},{"id":309,"text":"Psittacula krameri (Periquito-de-colar)"},{"id":302,"text":"Pterocles alchata (Cortiçol-de-barriga-branca)"},{"id":303,"text":"Pterocles orientalis (Cortiçol-de-barriga-preta)"},{"id":90,"text":"Pterodroma feae (Freira do Bugio)"},{"id":91,"text":"Pterodroma madeira (Freira da Madeira)"},{"id":346,"text":"Ptyonoprogne rupestris (Androinha-das-rochas)"},{"id":98,"text":"Puffinus assimilis (Pardela-pequena)"},{"id":94,"text":"Puffinus gravis (Pardela-de-bico-preto)"},{"id":95,"text":"Puffinus griseus (Pardela-preta)"},{"id":96,"text":"Puffinus puffinus (Pardela-sombria)"},{"id":97,"text":"Puffinus yelkouan (Pardela do Mediterrâneo)"},{"id":435,"text":"Pyrrhocorax pyrrhocorax (Gralha-de-bico-vermelho)"},{"id":463,"text":"Pyrrhula pyrrhula (Dom-fafe)"},{"id":199,"text":"Rallus aquaticus (Frango-d'água)"},{"id":522,"text":"Rana iberica (Rã-ibérica)"},{"id":73,"text":"Rattus norvegicus (Ratazana-de-agua)"},{"id":74,"text":"Rattus rattus (Ratazana)"},{"id":213,"text":"Recurvirostra avosetta (Alfaiate)"},{"id":390,"text":"Regulus ignicapilla (Estrelinha-de-cabeça-listada)"},{"id":391,"text":"Regulus regulus (Estrelinha-de-poupa)"},{"id":423,"text":"Remiz pendulinus (Chapim-de-faces-pretas)"},{"id":5072,"text":"Rhinechis scalaris (Cobra-de-escada)"},{"id":23,"text":"Rhinolophus euryale (Morcego-de-ferradura-mediterrânico)"},{"id":24,"text":"Rhinolophus ferrumequinum (Morcego-de-ferradura-grande)"},{"id":25,"text":"Rhinolophus hipposideros (Morcego-de-ferradura-pequeno)"},{"id":26,"text":"Rhinolophus mehelyi (Morcego-de-ferradura-mourisco)"},{"id":344,"text":"Riparia riparia (Andorinha-das-barreiras)"},{"id":287,"text":"Rissa tridactyla (Gaivota-tridáctila)"},{"id":5040,"text":"Rutilus rutilus (Ruivo; Rutilo)"},{"id":508,"text":"Salamandra salamandra (Salamandra-de-pintas-amarelas)"},{"id":5013,"text":"Salaria fluviatilis (Caboz-de-água-doce; Peixe-rei)"},{"id":5041,"text":"Salmo salar (Salmão do Atlântico; Salmão)"},{"id":5049,"text":"Salmo trutta (Truta-marisca; Truta-fário; Truta-de-rio)"},{"id":5042,"text":"Sander lucioperca (Sandre; Lucioperca)"},{"id":380,"text":"Saxicola rubetra (Cartaxo-nortenho)"},{"id":381,"text":"Saxicola rubicola (Cartaxo-comum)"},{"id":75,"text":"Sciurus vulgaris (Esquilo)"},{"id":227,"text":"Scolopax rusticola (Galinhola)"},{"id":457,"text":"Serinus serinus (Chamariz-comum)"},{"id":5032,"text":"Silurus glanis (Peixe-gato-europeu; Siluro-europeu; Siluro)"},{"id":425,"text":"Sitta europaea (Trepadeira-azul)"},{"id":150,"text":"Somateria mollissima (Eider-edredão)"},{"id":55,"text":"Sorex granarius (Musaranho-de-dentes-vermelhos)"},{"id":56,"text":"Sorex minutus (Musaranho-anão-de-dentes-vermelhos)"},{"id":5018,"text":"Squalius aradensis (Escalo do Arade)"},{"id":5020,"text":"Squalius carolitertii (Escalo do Norte)"},{"id":5021,"text":"Squalius pyrenaicus (Escalo do Sul)"},{"id":5019,"text":"Squalius torgalensis (Escalo do Mira; Escalo do Torgal)"},{"id":272,"text":"Stercorarius longicaudus (Moleiro-de-cauda-comprida)"},{"id":271,"text":"Stercorarius parasiticus (Moleiro-parasítico)"},{"id":270,"text":"Stercorarius pomarinus (Moleiro-pomarino)"},{"id":294,"text":"Sterna albifrons (Andorinha-do-mar-anã)"},{"id":291,"text":"Sterna dougallii (Andorinha-do-mar-rósea)"},{"id":292,"text":"Sterna hirundo (Andorinha-do-mar-comum)"},{"id":293,"text":"Sterna paradisaea (Andorinha-do-mar-árctica)"},{"id":308,"text":"Streptopelia decaocto (Rola-turca)"},{"id":5068,"text":"Streptopelia risoria (Rola-doméstica)"},{"id":307,"text":"Streptopelia turtur (Rola-comum)"},{"id":318,"text":"Strix aluco (Coruja-do-mato)"},{"id":440,"text":"Sturnus unicolor (Estorninho-preto)"},{"id":439,"text":"Sturnus vulgaris (Estorinho-malhado)"},{"id":103,"text":"Sula bassana (Ganso-patola)"},{"id":57,"text":"Suncus etruscus (Musaranho-anão-de-dentes-brancos)"},{"id":6,"text":"Sus scrofa (Javali)"},{"id":411,"text":"Sylvia atricapilla (Toutinegra-de-barrete-preto)"},{"id":412,"text":"Sylvia borin (Felosa-das-figueiras)"},{"id":417,"text":"Sylvia cantillans (Toutinegra-carrasqueira)"},{"id":414,"text":"Sylvia communis (Papa-amoras-comum)"},{"id":416,"text":"Sylvia conspicillata (Toutinegra-tomilheira)"},{"id":413,"text":"Sylvia hortensis (Toutinegra-real)"},{"id":418,"text":"Sylvia melanocephala (Toutinegra-de-cabeça-preta)"},{"id":415,"text":"Sylvia undata (Felosa-do-mato)"},{"id":86,"text":"Tachybaptus ruficollis (Mergulhão-pequeno)"},{"id":324,"text":"Tachymarptis melba (Andorinhão-real)"},{"id":22,"text":"Tadarida teniotis (Morcego-rabudo)"},{"id":131,"text":"Tadorna ferruginea (Pato-ferrugíneo)"},{"id":132,"text":"Tadorna tadorna (Pato-branco)"},{"id":59,"text":"Talpa occidentalis (Toupeira)"},{"id":479,"text":"Tarentola mauritanica (Osga-comum)"},{"id":485,"text":"Teira dugesii (Lagartixa da Madeira)"},{"id":210,"text":"Tetrax tetrax (Sisão)"},{"id":290,"text":"Thalasseus sandvicensis (Garajau-comum)"},{"id":503,"text":"Thinechis scalaris (Cobra-de-escada)"},{"id":117,"text":"Threskiornis aethiopicus (Íbis-sagrada)"},{"id":426,"text":"Tichodroma muraria (Trepadeira-dos-muros)"},{"id":486,"text":"Timon lepidus (Sardão)"},{"id":5047,"text":"Tinca tinca (Tenca)"},{"id":475,"text":"Trachemys scripta (Tartaruga da Flórida)"},{"id":238,"text":"Tringa erythropus (Perna-vermelha-escuro)"},{"id":243,"text":"Tringa flavipes (Perna-amarela-pequeno)"},{"id":246,"text":"Tringa glareola (Maçarico-bastardo)"},{"id":242,"text":"Tringa melanoleuca (Perna-amarela-grande)"},{"id":241,"text":"Tringa nebularia (Perna-verde-comum)"},{"id":244,"text":"Tringa ochropus (Pássaro-bique-bique)"},{"id":245,"text":"Tringa solitaria (Maçarico-solitário)"},{"id":240,"text":"Tringa stagnatilis (Perna-verde-fino)"},{"id":239,"text":"Tringa totanus (Perna-vermelha-comum)"},{"id":509,"text":"Triturus marmoratus (Tritão-marmorado)"},{"id":510,"text":"Triturus pygmaeus (Tritão-pigmeu)"},{"id":363,"text":"Troglodytes troglodytes (Carriça)"},{"id":5012,"text":"Tropidophoxinellus alburnoides (Bordalo; Ruivaca)"},{"id":265,"text":"Tryngites subruficollis (Pilrito-canela)"},{"id":368,"text":"Turdus iliacus (Tordo-ruivo-comum)"},{"id":370,"text":"Turdus merula (Melro-preto)"},{"id":367,"text":"Turdus philomelos (Tordo-comum)"},{"id":369,"text":"Turdus pilaris (Tordo-zornal)"},{"id":371,"text":"Turdus torquatus (Melro-de-peito-branco)"},{"id":366,"text":"Turdus viscivorus (Tordeia)"},{"id":197,"text":"Turnix sylvatica (Toirão)"},{"id":315,"text":"Tyto alba (Coruja-das-torres)"},{"id":332,"text":"Upupa epops (Poupa)"},{"id":299,"text":"Uria aalge (Arau-comum)"},{"id":218,"text":"Vanellus gregarius (Abibe-sociável)"},{"id":217,"text":"Vanellus vanellus (Abibe-comum)"},{"id":504,"text":"Vipera latastei (Víbora-cornuda)"},{"id":505,"text":"Vipera seoanei (Víbora de Seoane)"},{"id":8,"text":"Vulpes vulpes (Raposa)"},{"id":286,"text":"Xema sabini (Gaivota de Sabine)"},{"id":247,"text":"Xenus cinereus (Maçarico-sovela)"}];
    $("#especie").select2({
        placeholder: 'Espécie',
        data: data
    });    
    
    $('#especie').on('select2-selecting', function(evt){
        $('#especie').select2('container')
            .css('border', 'none');
    });
    
    $("#sys_class").select2({
        placeholder: 'Tipo de classe',
        allowClear: true,
        ajax: {
            url: 'services/get_species_fields.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    sys_class: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    
    $("#sys_class")
        .on('select2-selecting', function(evt){
            $('#sys_class_val')
                .select2('enable', true)
                .select2('val', '');
            $('#sys_class').select2('container')
                .css('border', 'none');
        })
        .on('select2-clearing', function(evt){
            $('#sys_class_val')
                .select2('enable', false)
                .select2('val', '');
        });
    
    
    $("#sys_class_val").select2({
        placeholder: 'Classe',
        allowClear: true,
        ajax: {
            url: 'services/get_class_values.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    sys_class_val: $('#sys_class').select2('data').text,
                    val: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    $('#sys_class_val').on('select2-selecting', function(evt){
	    $('#sys_class_val').select2('container')
	        .css('border', 'none');
    });
    
    //phenology old
//     $("#phenology, #phenology_aproximate").select2({
//         placeholder: 'Fenologia',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_phenology.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     phenology: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
    
    
    var data = [{"id":12,"text":"abrigo"},{"id":11,"text":"colonia de hibernação"},{"id":10,"text":"colonia de reprodução"},{"id":9,"text":"introduzido"},{"id":5,"text":"invernante"},{"id":4,"text":"migador estival"},{"id":3,"text":"migrador"},{"id":1,"text":"NA"},{"id":6,"text":"nidificante"},{"id":8,"text":"nidificante estival"},{"id":7,"text":"ocasional"},{"id":2,"text":"residente"}]; 
    $("#phenology, #phenology_aproximate").select2({
		placeholder: 'Fenologia',
		data: data
	});
	$('#phenology, #phenology_aproximate').val('1').trigger('change')
	
    
    $('#phenology').on('select2-selecting', function(evt){
        $('#phenology').select2('container')
            .css('border', 'none');
    });
    
    $('#phenology_aproximate').on('select2-selecting', function(evt){
        $('#phenology_aproximate').select2('container')
            .css('border', 'none');
    });
    
    
    
    //age old
//     $("#age, #age_aproximate").select2({
//         placeholder: 'Idade',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_ages.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     age: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
//     
//     $('#age').on('select2-selecting', function(evt){
//         $('#age').select2('container')
//             .css('border', 'none');
//     });
//     
//     $('#age_aproximate').on('select2-selecting', function(evt){
//         $('#age_aproximate').select2('container')
//             .css('border', 'none');
//     });
    
        //age new
    var data = [{ id: 0, text: 'indeterminada' }, { id: 1, text: 'sub-adulto' }, { id: 2, text: 'adulto' }, { id: 3, text: 'jovem' }]; 
    $("#age, #age_aproximate").select2({
		placeholder: 'Idade',
		data: data
	});
	$('#age, #age_aproximate').val('0').trigger('change')
	
	$('#age, #age_aproximate').on('select2-selecting', function(evt){
        $('#age, #age_aproximate').select2('container')
            .css('border', 'none');
    });
    
    
    //sex old
//     $('#sex, #sex_aproximate').select2({
//         placeholder: 'Sexo',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_sex.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     sex: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
	
    var data = [{"id":3,"text":"femea"},{"id":1,"text":"indeterminado"},{"id":2,"text":"macho"}]; 
    $("#sex, #sex_aproximate").select2({
		placeholder: 'Idade',
		data: data
	});
	$('#sex, #sex_aproximate').val('1').trigger('change')
	
    
    $('#sex').on('select2-selecting', function(evt){
        $('#sex').select2('container')
            .css('border', 'none');
    });
    
    $('#sex_aproximate').on('select2-selecting', function(evt){
        $('#sex_aproximate').select2('container')
            .css('border', 'none');
    });
    
    //behaviour old
//     $("#behavior, #behavior_aproximate").select2({
//         placeholder: 'Comportamento',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_behavior.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     behavior: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
    
    var data = [{"id":7,"text":"alimentação"},{"id":2,"text":"fuga"},{"id":1,"text":"NA"},{"id":6,"text":"no solo"},{"id":4,"text":"repouso"},{"id":3,"text":"reprodução"},{"id":5,"text":"voo"}]; 
    $("#behavior, #behavior_aproximate").select2({
		placeholder: 'Idade',
		data: data
	});
	$('#behavior, #behavior_aproximate').val('1').trigger('change')
    
    $('#behavior').on('select2-selecting', function(evt){
        $('#behavior').select2('container')
            .css('border', 'none');
    });
    
    $('#behavior_aproximate').on('select2-selecting', function(evt){
        $('#behavior_aproximate').select2('container')
            .css('border', 'none');
    });
    
    $("input[name='individuals'], input[name='individuals_aproximate']").TouchSpin({
        max: 1000,
        min: 1,
        buttondown_class: 'btn btn-default btn-sm', 
        buttonup_class: 'btn btn-default btn-sm'
    });
    
    $('#km').TouchSpin({
		max: 1000,
        min: 0,
        step: 0.1,
        decimals: 1,	
        buttondown_class: 'btn btn-default btn-sm', 
        buttonup_class: 'btn btn-default btn-sm'
	});
    
    //CHARACTERIZATION FORM
    //old project
//     $("#project").select2({
//         placeholder: 'Projecto',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_project.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     project: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
    
        //new project
    var data = [{ id: 1, text: 'LIFE LINES' }, { id: 0, text: 'MOVE' }, { id: 2, text: 'REFER' }]; 
    $("#project").select2({
		placeholder: 'Projecto',
		data: data
	}).select2("enable", false);;

	$('#project').val(projectidjs).trigger('change')    
    
    $('#project').on('select2-selecting', function(evt){
        $('#project').select2('container')
            .css('border', 'none');
    });
    
    
    //old method
//     $("#method").select2({
//         placeholder: 'Método',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_method.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     method: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
    
            //new method
    if (projectidjs == 0) {
    var data = [{ id: 0, text: 'trajeto automóvel lento' }];
} else if (projectidjs == 1) {
    var data = [{ id: 1, text: 'armadilhagem fotográfica' }, { id: 0, text: 'estações de cheiro' }, { id: 2, text: 'monitorização de passagens hidráulicas' }];
} else {
    var data = [{ id: 1, text: 'armadilhagem fotográfica' }, { id: 0, text: 'rede aves' }, { id: 2, text: 'detector ultrassom móvel' }];
} 
    $("#method").select2({
		placeholder: 'Método',
		data: data
	});

    if (projectidjs == 0) {
    $('#method').val('0').trigger('change')
} else if (projectidjs == 1) {
    $('#method').val('0').trigger('change')
} else {
    $('#method').val('0').trigger('change')
} 
    
    $('#method').on('select2-selecting', function(evt){
        $('#method').select2('container')
            .css('border', 'none');
    });
    
    
    //Novo campo na tab MOVE
    var data = [{ id: 0, text: 'esmagado' }, { id: 1, text: 'inteiro' }, { id: 2, text: 'parcialmente inteiro' }, { id: 3, text: 'resto' }]; 
    $('#cons').select2({
		placeholder: 'Estado',
		data: data
	});
	$('#cons').val('0').trigger('change')
	
	$('#cons').on('select2-selecting', function(evt){
        $('#cons').select2('container')
            .css('border', 'none');
    });
	
	
	//FIM do novo campo

    //Novo campo na tab MOVE
    var data = [{ id: 0, text: 'recente' }, { id: 1, text: 'antigo' }, { id: 2, text: 'muito antigo' }]; 
    $('#anti').select2({
		placeholder: 'Antiguidade',
		data: data
	});
	$('#anti').val('0').trigger('change')
	
	$('#anti').on('select2-selecting', function(evt){
        $('#anti').select2('container')
            .css('border', 'none');
    });
	
	
	//FIM do novo campo


    //Novo campo na tab MOVE
    var data = [{ id: 2, text: 'N4' }, { id: 4, text: 'N18' }, { id: 1, text: 'N114' }, { id: 8, text: 'N370' }, { id: 3, text: 'M529' }, { id: 7, text: 'M370' }]; 
    $('#estrada').select2({
		placeholder: 'Estrada',
		data: data
	});
    if (typeof estradamoveid !== 'undefined') {$('#estrada').val(estradamoveid).trigger('change')}
    else {
    $('#estrada').val('1').trigger('change')
	}
	
	$('#estrada').on('select2-selecting', function(evt){
        $('#estrada').select2('container')
            .css('border', 'none');
    });
	
	
	//FIM do novo campo	

	
    //Novo campo na tab MOVE
    var data = [{ id: 0, text: 'F1' }, { id: 1, text: 'F2' }, { id: 2, text: 'B1' }, { id: 3, text: 'B2' }, { id: 4, text: 'Fora1' }, { id: 5, text: 'Fora2' }, { id: 6, text: 'Centro' }, { id: 7, text: 'F1-B1' }, { id: 8, text: 'F2-B2' }, { id: 9, text: 'B1-Fora1' }, { id: 10, text: 'B2-Fora2' }, { id: 11, text: 'Centro SC' }, { id: 12, text: 'Indeterminado' }]; 
    $('#zona_atr').select2({
		//placeholder: 'Zona',
		data: data
	});
    $('#zona_atr').val('0').trigger('change')
	
	$('#zona_atr').on('select2-selecting', function(evt){
        $('#zona_atr').select2('container')
            .css('border', 'none');
    });
	
	
	//FIM do novo campo	
    
    //old type	
//     $("#type").select2({
//         placeholder: 'Tipo',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_type.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     type: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
//     
	
	
    //new type
        var data = [{"id":17,"text":"aste"},{"id":28,"text":"canto"},{"id":27,"text":"cranio ou dentes"},{"id":7,"text":"dejeto"},{"id":25,"text":"direta vivo"},{"id":13,"text":"escamas"},{"id":10,"text":"esgravatado"},{"id":18,"text":"fotografia"},{"id":19,"text":"inquérito"},{"id":8,"text":"latrina"},{"id":22,"text":"montículo"},{"id":2,"text":"morto"},{"id":1,"text":"morto atropelado"},{"id":20,"text":"ninho"},{"id":9,"text":"pegada"},{"id":14,"text":"pele"},{"id":11,"text":"pelos"},{"id":12,"text":"penas"},{"id":15,"text":"resto de alimento"},{"id":16,"text":"roçado em arvores"},{"id":23,"text":"toca"},{"id":24,"text":"trilho"},{"id":21,"text":"túnel na vegetação"},{"id":6,"text":"ultrassom feedbing buzz"},{"id":3,"text":"ultrassom navegação"},{"id":5,"text":"ultrassom social call"}]; 
    $('#type').select2({
		placeholder: 'Tipo',
		data: data
	});
    
        if (projectidjs == 0) {
    $('#type').val('1').trigger('change')
}

    
    $('#type').on('select2-selecting', function(evt){
        $('#type').select2('container')
            .css('border', 'none');
    });
    
    $('#data').datetimepicker({
        pickTime: false,
        useCurrent: false,
        showToday: true
    });
    
    $("#data").on("dp.change",function (e) {
        $('#data').removeClass('has-error');
    });
    
    $('#data').data('DateTimePicker').setDate(new Date());
    
    $('#time').datetimepicker({
        pickDate: false
    });
    
    $("#time").on("dp.change",function (e) {
        $('#time').removeClass('has-error');
    });
    
    $('#time').data('DateTimePicker').setDate(new Date());
    
    //LOCALIZATION FORM
    //MAP
    function addMap(){
        //BaseLayers
        var osm = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        var gstreets = new L.Google('ROADMAP');
        var gsat = new L.Google();
        
        //Overlay Layers
        var grid10 = new L.TileLayer.WMS("http://mapserver.uevora.pt/cgi-bin/ocorrencias/qgis_mapserv.fcgi", {
//            map: '/var/www/ub_ocorrencias/ocorrencias.qgs',
            layers: 'grelha UTM 10km',
            format: 'image/png',
            transparent: 'TRUE'
        });
        
        var grid2 = new L.TileLayer.WMS("http://mapserver.uevora.pt/cgi-bin/ocorrencias/qgis_mapserv.fcgi", {
//            map: '/var/www/ub_ocorrencias/ocorrencias.qgs',
            layers: 'grelha UTM 2km',
            format: 'image/png',
            transparent: 'TRUE'
        });
        
        window.map = L.map('map', {
            scrollWheelZoom: false
        });
        map.blueMarker = new Array();
        map.greenMarker = new Array();
        map.appLayers = [osm, gstreets, gsat, grid10, grid2];
        map.setView([39.704314, -8.127506], 6);
        
        map.addLayer(osm);
        
        //Layer Control
        var baseLayers = {
            'OSM': osm,
            'Google Streets': gstreets,
            'Google Satellite': gsat
        };
        
        var overlayLayers = {
            "Grelha 10 km": grid10,
            'Grelha 2 km': grid2
        };
        
        L.control.layers(baseLayers, overlayLayers).addTo(map);
        
        //Geolocate
        map.on('accuratepositionprogress', onAccuratePositionProgress);
		map.on('accuratepositionfound', onAccuratePositionFound);
		map.on('accuratepositionerror', onAccuratePositionError);
        map.on('click', onMapClick);
        
        //Geolocate
        L.easyButton(
            'fa-crosshairs',
            function (){geoLocate();},
            'Geolocalizar'
        ); 
        
        //initial geolocate
        geoLocate();
        
        return map;
    }
    
    function onMapClick(e) {
        var coords = reprojWgsToUtm([e.latlng.lng, e.latlng.lat]);
        $('#xcoord')
            .val(coords[0])
            .parent().removeClass('has-error');
        $('#ycoord')
            .val(coords[1])
            .parent().removeClass('has-error');
        
        if (map.greenMarker.length > 0){
            eraseMarkers(map.greenMarker);
        }
        var marker = L.marker(e.latlng, {icon: greenicon});
        map.greenMarker.push(marker);
        map.addLayer(marker);
    }
    
    function onMapClickAjax(e) {  
        $('#dialog-info').css('display', 'flex');
        $('#dialog-error').css('display', 'none');
        $('#dialog-progress').css('display', 'flex');
        $('#dialog-btn').css('display', 'none');
        $('#dialog').modal('toggle');
        
        $('#xcoord').val('');
        $('#ycoord').val('');
        $('#folha').val('');
        var coords = reprojWgsToUtm([e.latlng.lng, e.latlng.lat]);
        
        if (map.greenMarker.length > 0){
            eraseMarkers(map.greenMarker);
        }
        var marker = L.marker(e.latlng, {icon: greenicon});
        map.greenMarker.push(marker);
        map.addLayer(marker);
        
        $.ajax({
            type: 'POST',
            url : 'services/get_grid_coords.php',
            data: { x: coords[0], y: coords[1] , grid: map.selectedGrid},
            dataType: 'json',
            success: function(response){
                if (response.success == true){
                    $('#xcoord')
                        .val(response.data[0].x)
                        .parent().removeClass('has-error');
                    $('#ycoord')
                        .val(response.data[0].y)
                        .parent().removeClass('has-error');
                    $('#folha')
                        .val(response.data[0].folha)
                        .parent().removeClass('has-error');
                    var coords = reprojWgsToUtm([response.data[0].x, response.data[0].y], 'inverse');
                    eraseMarkers(map.greenMarker);
                    var marker = L.marker(coords.reverse(), {icon: greenicon});
			        map.greenMarker.push(marker);
			        map.addLayer(marker);
                    map.setView(coords);
                    if (map.getZoom() < 12){
                        map.setZoom(12);
                    }
                    $('#dialog').modal('toggle');
                    $('#dialog-info')
                        .css('display', 'flex')
                        .html('A obter dados. Por favor aguarde...');
		            $('#dialog-success').css('display', 'none');
		            $('#dialog-progress').css('display', 'block');
		            $('#dialog-error').css('display', 'none');
                } else {
                    $('#dialog-info').css('display', 'none');
                    $('#dialog-success').css('display', 'none');
			        $('#dialog-error')
                        .css('display', 'flex')
                        .html('Ocorreu um erro ao obter os dados! ' + response.msg);
			        $('#dialog-progress').css('display', 'none');
			        $('#dialog-btn').css('display', 'block');
                }
            }
        });
    }
    
    function eraseMarkers(markers){
        for (var i = 0; i < markers.length; i++){
            map.removeLayer(markers[i]);
        }
    }
    
    function geoLocate(){
        map.findAccuratePosition({
            maxWait: 10000,
            desiredAccuracy: 20
        });
    }
    
    function onAccuratePositionError (e) {
        var msg = 'Ocorreu um erro durante a geolocalização: ' + e.message.split(': ')[1];
         if ($('#gps').find('.alert-info').size() != 0){
            $('#gps').find('.alert')
	            .removeClass('alert-info')
                .removeClass('alert-success')
	            .addClass('alert-danger')
                .html(msg);
         } else {
            $('#gps').find('.alert')
                .removeClass('alert-warning')
                .removeClass('alert-info')
                .addClass('alert-danger')
                .html(msg);
         }
    }

    function onAccuratePositionProgress (e) {
        $('#gps').find('.alert')
            .removeClass('alert-warning')
            .removeClass('alert-success')
            .removeClass('alert-danger')
            .addClass('alert-info')
            .html('Geolocalização em progresso. Por favor aguarde.');
    }

    function onAccuratePositionFound (e) {
        if (map.blueMarker.length > 0){
            eraseMarkers(map.blueMarker);
        }
        
        var coords = reprojWgsToUtm([e.latlng.lng, e.latlng.lat]);
        $('#gps').find('.alert')
            .removeClass('alert-info')
            .removeClass('alert-danger')
            .addClass('alert-success')
            .html('Geolocalização bem sucedida. Coordenadas UTM Zona 29N - <b>X: </b>' + Math.round(coords[0] * 100000) / 100000 + ' m; <b>Y: </b>' + Math.round(coords[1] * 100000) / 100000 + ' m; <b>Precisão: </b>' + Math.round((e.accuracy / 2) * 100) /100  + ' m');
        map.setView(e.latlng, 16);
        L.marker(e.latlng).addTo(map);
        var radius = Math.round((e.accuracy / 2) * 100) / 100;
        L.circle(e.latlng, radius).addTo(map);
	document.getElementById('xcoord').value=Math.round(coords[0] * 100000) / 100000
	document.getElementById('ycoord').value=Math.round(coords[1] * 100000) / 100000	
    }
    
    function reprojWgsToUtm(coords, direction){
        var wgs = '+proj=longlat +datum=WGS84 +no_defs ';
        var utm = '+proj=utm +zone=29 +datum=WGS84 +units=m +no_defs';
        
        if (direction == 'inverse'){
            return proj4(utm, wgs, coords);
        } else {
            return proj4(wgs, utm, coords);
        }
    }
    
    //MAP-FORM
    //OBSERVATION RADIOS
    $('#local input[name="local-method"]').click(function(){
        if (map.greenMarker.length > 0){
            eraseMarkers(map.greenMarker);
        }
        var method = $('input[name="local-method"]:checked').val();
        if (method == 'click' || method == 'grid'){
            map.on('click', onMapClick);
            $('#xcoord')
                .attr('disabled', true)
                .val('');
            $('#ycoord')
                .attr('disabled', true)
                .val('');
            $('#update-map').css('display', 'none');
        } else { //method == 'manual'
            map.off('click', onMapClick);
            $('#xcoord')
                .attr('disabled', false)
                .val('');
            $('#ycoord')
                .attr('disabled', false)
                .val('');
            $('#update-map').css('display', 'block');
        }
        
        if (method == 'grid'){
            $('#map-aproximate').css('display', 'block');
            $('#biotopo-section').css('display', 'block');
	    $('#biotopo-sectionclc5').css('display', 'block');
            map.off('click', onMapClick);
        } else {
             $('#map-aproximate').css('display', 'none');
             $('#biotopo-section').css('display', 'none');
             $('#biotopo-sectionclc5').css('display', 'none');
             $('#grid').select2('val', '');
        }
    });
    
	$("#xcoord").keypress(function (e) {
		return restrictNumbers(e, '#xcoord');
	});
    
    $("#xcoord").focusout(function (e) {
        if ($("#xcoord").val() != ''){
            $("#xcoord")
                .parent().removeClass('has-error');
        }
    });
    
    $("#ycoord").keypress(function (e) {
        return restrictNumbers(e, '#ycoord');
    });
    
    $("#ycoord").focusout(function (e) {
        if ($("#ycoord").val() != ''){
            $("#ycoord")
                .parent().removeClass('has-error');
        }
    });
    
    function restrictNumbers(e, id){
        if (e.which == 46){
            if ($(id).val().indexOf('.') != -1){
                return false;
            } else {
                return true;
            }
        } else if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        } else {
            return true;
        }
    }
    
    $('#update-map').click(
        function(){
            if ($('#ycoord').val() != '' && $('#xcoord').val() != ''){
	            var coords = reprojWgsToUtm([$('#xcoord').val(), $('#ycoord').val()], 'inverse');
	            var marker = L.marker([coords[1], coords[0]], {icon: greenicon});
		        map.greenMarker.push(marker);
		        map.addLayer(marker);
	            map.setView(coords.reverse(), 12);
            }
        }
    );
    
    
    $("#grid").select2({
        placeholder: 'Grelha UTM',
        allowClear: true,
        minimumResultsForSearch: -1, //hide search box
        data: [
            {id: 1, text: 'Grelha 10 km'},
            {id: 2, text: 'Grelha 2 km'}
        ]
    });
    
    $("#grid")
        .on('select2-selecting', function(evt){
            if (evt.val == 1){ //grelha de 10 km
				map.addLayer(map.appLayers[3]);   
				map.removeLayer(map.appLayers[4]);
                map.selectedGrid = 10;
            } else {
                map.addLayer(map.appLayers[4]);
                map.removeLayer(map.appLayers[3]);
                if (map.getZoom() < 12){
                    map.setZoom(12);
                }
                map.selectedGrid = 2;
            }
            map.off('click', onMapClickAjax);
            map.on('click', onMapClickAjax);
            if (map.greenMarker.length > 0){
	            eraseMarkers(map.greenMarker);
	        }
            $('#xcoord')
                .val('')
                .parent().removeClass('has-error');
            $('#ycoord')
                .val('')
                .parent().removeClass('has-error');
            $('#folha')
                .val('')
                .parent().removeClass('has-error');
            
            $('#grid').select2('container')
                .css('border', 'none');
        })
        .on('select2-clearing', function(evt){
            map.removeLayer(map.appLayers[3]);
            map.removeLayer(map.appLayers[4]);
            map.selectedGrid = null;
            map.off('click', onMapClickAjax);
            $('#xcoord').val('');
            $('#ycoord').val('');
            $('#folha').val('');
        });
        
    $("#biotopo").select2({
        placeholder: 'Biótopo CLC3',
        allowClear: true,
        ajax: {
            url: 'services/get_clc.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    legend: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    

        $("#biotopoclc5").select2({
        placeholder: 'Biótopo CLC5',
        allowClear: true,
        ajax: {
            url: 'services/get_clc5.php',
            dataType: 'json',
            data: function(term, page){
                return {
                   legendclc5: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                   return {results: data};
                }
            }
        }
    });

    //BUTTONS
    $('#validate').click(
       function(){
            validateForm();
       }
    );
    
    function getComponentIds(){
        var finalIds = {};
        var observation = $('input[name="obs"]:checked').val();
        var sharedComboIds = ['phenology', 'age', 'sex', 'behavior'];
        var sharedCombosIdsMove = ['cons','zona_atr','anti','estrada'];
        var sharedIndivualsIds = ['individuals', 'individuals_type'];
        var commonComboIds = ['project', 'method', 'type'];
        var dateTimeIds = ['data', 'time'];
        var localizationIds = ['xcoord', 'ycoord'];
        var moveTxtIds = ['textolivre'];
        
        if (observation == 'exacta'){
            var comboIds = ['especie'].concat(sharedComboIds);
        } else {
            var comboIds = ['sys_class', 'sys_class_val'];
            comboIds = comboIds.concat(adjustIdNames(sharedComboIds));
            sharedIndivualsIds = adjustIdNames(sharedIndivualsIds);
        }
        
        var method = $('input[name="local-method"]:checked').val();
        if (method == 'grid'){
            var localComboIds = ['grid', 'biotopo', 'biotopoclc5'];
            localizationIds = localizationIds.concat('folha');
            finalIds['localComboIds'] = localComboIds;
        }
        
        finalIds['observation'] = observation;
        finalIds['comboIds'] = comboIds;
        finalIds['sharedCombosIdsMove'] = sharedCombosIdsMove;
        finalIds['sharedIndivualsIds'] = sharedIndivualsIds;
        finalIds['commonComboIds'] = commonComboIds;
        finalIds['dateTimeIds'] = dateTimeIds;
        finalIds['localizationIds'] = localizationIds;
        finalIds['moveTxtIds'] = moveTxtIds;
        finalIds['method'] = method;
        
        return finalIds;
    }
    
    function validateForm(){
        var componentIds = getComponentIds();
        var html = 'O seu formulário não apresenta erros de preenchimento. Por favor carregue em submeter para enviar os dados.';
        var errorHtml = 'O seu formulário apresenta erros de preenchimento nas seguintes secções: <br>';
        var success = true;
        
        //Identification form
        var idCount = validateCombos(componentIds['comboIds']);
        if (idCount > 0){
            success = false;
            html = errorHtml;
            html += '- Identificação <br>'
        }
        
        //Characterization form
        var charCombo = validateCombos(componentIds['commonComboIds']);
        var dateTime = validateDateTime(componentIds['dateTimeIds']);
        
        if (charCombo + dateTime > 0){
            if (success == true){
                success = false;
                html = errorHtml;
            }
            html += '- Caracterização <br>'
        }
        
        //Localization form
        var textFields = validateTextFields(componentIds['localizationIds'])
        if (componentIds['method'] == 'grid'){
            var localCombos = validateCombos([componentIds['localComboIds'][0]]);
        }

        if (textFields > 0  || (typeof localCombos != 'undefined' && localCombos > 0)){
            if (success == true){
                success = false;
                html = errorHtml;
            }
            html += '- Localização <br>'
        }
        
		
		var idCountMove = validateCombos(componentIds['sharedCombosIdsMove']);
        if (idCountMove > 0){
            if (success == true){
                success = false;
                html = errorHtml;
            }
            html += '- Move <br>'
        }
        
        var moveTxtFields = validateTextFields(componentIds['moveTxtIds']);
		if (moveTxtFields > 0 && idCountMove == 0){
            if (success == true){
                success = false;
                html = errorHtml;
            }
            html += '- Move <br>'
        }
		
        $('#msg-alert').css('display', 'block');
        if (success == false) {
            html += '<br>Por favor corrija os seus dados e valide novamente o formulário!';
            $('#msg-alert')
                .children()
                    .html(html)
                    .removeClass('alert-success')
                    .addClass('alert-danger');
        } else {
            $('#msg-alert')
                .children()
                    .html(html)
                    .removeClass('alert-danger')
                    .addClass('alert-success');
            $('#submit').removeAttr('disabled');
        }
    }
    
    function validateCombos(ids){
        var results = {};
        var counter = 0;
        for (var i = 0; i < ids.length; i++){
            if ( $('#' + ids[i]).select2('data') == null ){
                counter += 1;
                $('#' + ids[i]).select2('container')
                    .css('border', '1px solid rgba(185, 74, 72, .9)')
                    .css('border-radius', '4px');
            }
        }
        
        return counter;
    }
    
    function validateDateTime(ids){
        var counter = 0;
        for (var i = 0; i < ids.length; i++){
            if ( $('#' + ids[i]).data('DateTimePicker').getDate() == null || typeof $('#' + ids[i]).data('DateTimePicker').getDate()._i == 'undefined' ){
                counter += 1;
                $('#' + ids[i]).addClass('has-error');
            }
        }
        
        return counter;
    }
    
    function validateTextFields(ids){
        var counter = 0;
        for (var i = 0; i < ids.length; i++){
            if ($('#' + ids[i]).val() == ''){
                $('#' + ids[i]).parent().addClass('has-error');
                counter += 1;
            } else {
				$('#' + ids[i]).parent().removeClass('has-error');
			}
        }
        
        return counter;
    }
    
    $('#submit').click(
        function(){
            var componentIds = getComponentIds();
            
            //Identification form
            var comboValues = getComboValues(componentIds['comboIds']);
            var individualsValues = getIndividualsValues(componentIds['sharedIndivualsIds']);
            var idData = mergeObjects(comboValues, individualsValues); //identification form values
            idData['obs'] = componentIds['observation'];
            
            //Characterizatin form
            var commonComboValues = getComboValues(componentIds['commonComboIds']);
            var dateTime = formatDateTime($('#data').data("DateTimePicker").getDate(), $('#time').data("DateTimePicker").getDate());
            var charData = mergeObjects(commonComboValues, dateTime);
            charData['notas'] = $('#notas').val();

	    
	    //move form
	    var sharedCombosValuesMove = getComboValues(componentIds['sharedCombosIdsMove']);
	    var charrData = mergeObjects(sharedCombosValuesMove, dateTime);
	    charrData['adn'] = $('#adn').val();
	    var charrDataa = mergeObjects(sharedCombosValuesMove, dateTime);
	    charrDataa['km'] = $('#km').val();

            //Localization form
            var localData = getPlainFieldValues(componentIds['localizationIds']);
            if (componentIds['method'] == 'grid'){
                var gridValues = getComboValues(componentIds['localComboIds']);
                localData = mergeObjects(localData, gridValues);
            }
            localData['local_type'] = componentIds['method'];
           
            var finalData = mergeObjects(idData, charData);
            finalData = mergeObjects(finalData, localData);
	    finalData = mergeObjects(finalData, charrData);
	    finalData = mergeObjects(finalData, charrDataa);
            finalData = mergeObjects(finalData, {'foto': fileName});
            
            $('#dialog').modal('toggle');
            $('#dialog-info')
                .css('display', 'flex')
                .html('A submeter dados. Por favor aguarde...');
            $('#dialog-success').css('display', 'none');
            $('#dialog-progress').css('display', 'block');
            $('#dialog-error').css('display', 'none');
            $.ajax({
	            type: 'POST',
	            url : 'services/new_observation.php',
	            data: finalData,
	            dataType: 'json',
	            success: function(response){
	                if (response.success == true){
	                    $('#dialog-info').css('display', 'none');
                        $('#dialog-success').css('display', 'flex');
                        $('#dialog-progress').css('display', 'none');
                        $('#dialog-btn').css('display', 'block');
                        //clearForm();
                        window.setInterval(location.reload(), 3000);
	                } else {
	                    $('#dialog-info').css('display', 'none');
                        $('#dialog-success').css('display', 'none');
                        $('#dialog-progress').css('display', 'none');
	                    $('#dialog-error')
	                        .css('display', 'flex')
	                        .html('Ocorreu um erro ao obter os dados! ' + response.msg);
	                    $('#dialog-btn').css('display', 'block');
	                }
	            }
	        });
        }
    );
    
    function getPlainFieldValues(ids){
        var results = {};
        for (var i = 0; i < ids.length; i++){
            results[ids[i]] = $('#' + ids[i]).val();
        }
        return results;
    }
    
    function formatDateTime(data, hora){
        var results = {};
        results['dia'] = data._i.d;
        if (typeof data._i.d == 'undefined'){
			results['dia'] = data._i.getDate();
			results['mes'] = data._i.getMonth();
			results['ano'] = data._i.getFullYear();
		} else {
			results['mes'] = data._i.M; //meses começam em 0 e acabam em 11
			results['ano'] = data._i.y;
		}
        
        results['hora'] = hora._d.getHours();
        results['minutos'] = hora._d.getMinutes();
        return results;
    }
    
    function adjustIdNames(ids){
        for (var i = 0; i < ids.length; i++){
            ids[i] = ids[i] + '_aproximate';
        }
        return ids;
    }
    
    function getComboValues(ids){
        var results = {};
        for (var i = 0; i < ids.length; i++){
            if (ids[i] == 'especie'){
                var tempData = $('#' + ids[i]).select2('data').text;
                tempData = tempData.split(' | ');
                results['especie'] = tempData[0];
                results['nome_vulgar'] = '';
                if (tempData.length > 1){
                    results['nome_vulgar'] = tempData[1];
                }
            } else {
                var data = $('#' + ids[i]).select2('data');
                if (data == null){
                    results[ids[i]] = '';
                } else {
                    results[ids[i]] = data.text;
                }
            }
        }
        return results;
    }
    
    function getIndividualsValues(ids){
        var results = {}
        results['individuals'] = $('#' + ids[0]).val();
        results['individuals_type'] = $('input[name="' + ids[1] + '"]:checked').parent().text();
        return results;
    }
    
    function mergeObjects(obj1, obj2){
        for (var name in obj2){
            obj1[name] = obj2[name];
        }
        return obj1;
    }
    
    function clearCombos(ids){
        for (var i = 0; i < ids.length; i++){
            $('#' + ids[i]).select2('val', '');
        }
    }
    
    function clearSpinners(ids){
        $('#' + ids[0]).val('1');
        $('input[name="' + ids[1] + '"]')[0].checked = true;
    }
    
    function clearDateTime(ids){
        for (var i = 0; i < ids.length; i++){
            $('#' + ids[i]).data("DateTimePicker").setDate('');
        }
    }
    
    function clearFields(ids){
        for (var i = 0; i < ids.length; i++){
            $('#' + ids[i]).val('');
        }
    }
    
    function clearForm(){
        var ids = getComponentIds();
        
        //Identification form
        clearCombos(ids.comboIds);
        clearSpinners(ids.sharedIndivualsIds);
        
        //Characterization form
        clearCombos(ids.commonComboIds);
        clearDateTime(['data', 'time']);
        $('#notas').val('');
        $('#adn').val('');
	
        //Localization form
        clearFields(ids.localizationIds);
        if (typeof ids.localComboIds != 'undefined'){
            clearCombos(ids.localComboIds);    
        }
        
        $('#form-tabs a[href="#identification"]').tab('show');
        $('#observation input[name="obs"][value="exacta"]')[0].checked = true;
        $('#aproximate-form').css('display', 'none');
        $('#exact-form').css('display', 'inline');
        
        eraseMarkers(map.greenMarker);
        map.off('click', onMapClick);
        map.off('click', onMapClickAjax);
        map.on('click', onMapClick);
        
        $('#local input[name="local-method"][value="click"]')[0].checked = true;
        $('#xcoord').attr('disabled', true);
        $('#ycoord').attr('disabled', true);
        $('#update-map').css('display', 'none');
        $('#map-aproximate').css('display', 'none');
        $('#biotopo-section').css('display', 'none');
        $('#biotopo-sectionclc5').css('display', 'none');
        
        $('#submit').attr('disabled', true);
        $('#msg-alert').css('display', 'none');
    }

	
	$('#fileupload').fileupload({
		singleFileUploads: true,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo(document.body);
                fileName = file.name;
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
