
var vorname
var nachname
var klasse
var mail
var handy
var nachhilfe
var fächer
var Anzahl
var bemerkungen 
var zahlen
var Zeiten
var msgvorname
let warnung1 = []
let warnung2 = []
let warnung3 = []
let warnung4 = []
let warnung5 = []


nachhilfe = document.getElementsByName("antwort")[0];
Anzahl = document.getElementsByName("auswahl")[0];
bemerkungen = document.getElementsByName("notiz")[0];

//püft ob man beim Nachhilfe geben mindestens in der 8.ten Klasse ist
klasse = document.getElementsByName('klassenstufe')[0];
function NachhilfeG() {
   if (klasse.value[0]>8) {
      warnung1 = [];
      document.querySelector(".msg.nachhilfe").innerHTML = warnung1;
   }
   else if(klasse.value[0]<3) {
      warnung1 = [];
      document.querySelector(".msg.nachhilfe").innerHTML = warnung1;
   }
   else {
      warnung1.splice(0,1,'Sie müssen mindestens 9.Klasse sein um Nachhilfe geben zu können.')
      document.querySelector(".msg.nachhilfe").innerHTML = warnung1;
   }
}

const result = [];
const options = document.querySelector("#fächer") && document.querySelector("#fächer").options;
let opt;
function Fächer() {
for (let i=0, iLen=options.length; i<iLen; i++) {
   opt = options[i];
   if (opt.selected) {
      result.push(opt.text);
   }
}
console.log(result);
}

//definiert welche Zeichen im Namen der Mail und der Telefonnummer vorkommen dürfen
let  regexName = /^([ \u00c0-\u01ffa-zA-Z\.' \-]{3,})+$/;
let  regexPhone =/^([0-9\.-\/ ()]{7,})$/;
let  regexEmail =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

let  errorname = true; 
let  erroremail = true; 
let  errorhandy = true;

vorname = document.getElementsByName('vorname')[0];
vorname.onfocus = function () {
   this.setAttribute('style','background: white');
}
//wenn man das Feld verlässt wird geprüft ob der Name die richtigen Zeichen enhält
vorname.onblur = function () {
   if (this.value.match(regexName)) {
      warnung2 = [];
      this.setAttribute('style','background: white');
      document.querySelector(".msg.vorname").innerHTML = warnung2;
      document.querySelector('.msg.vorname').setAttribute('style','display:none');
      errorname = false;
   } else {
      warnung2.splice(0,1,'Bitte geben sie ihren Vornamen ein')
      this.setAttribute('style','background:seashell');
      document.querySelector('.msg.vorname').innerHTML = warnung2
      document.querySelector('.msg.vorname').setAttribute('style','display:block');
      errorname = true;
   }
}

nachname = document.getElementsByName('nachname')[0];
nachname.onfocus = function () {
   this.setAttribute('style','background: white');
}
nachname.onblur = function () {
   if (this.value.match(regexName)) {
      warnung3 = [];
      this.setAttribute('style','background: white');
      document.querySelector('.msg.nachname').innerHTML = warnung3;
      document.querySelector('.msg.nachname').setAttribute('style','display:none');
      errorname = false;
   } else {
      warnung3.splice(0,1,'Bitte geben sie ihren Nachnamen ein!');
      this.setAttribute('style','background:seashell');
      document.querySelector('.msg.nachname').innerHTML = warnung3;
      document.querySelector('.msg.nachname').setAttribute('style','display:block');
      errorname = true;
   }
}

mail = document.getElementsByName('mail')[0];
mail.onfocus = function () {
   this.setAttribute('style','background: white');
}
mail.onblur = function () {
   if (this.value.match(regexEmail)) {
      warnung4 = [];
      this.setAttribute('style','background: white');
      document.querySelector('.msg.mail').innerHTML = warnung4;
      document.querySelector('.msg.mail').setAttribute('style','display:none');
      erroremail = false;
   } else {
      warnung4.splice(0,1,'Bitte geben sie ihre Emailadresse ein!');
      this.setAttribute('style','background:seashell');
      document.querySelector('.msg.mail').innerHTML = warnung4;
      document.querySelector('.msg.mail').setAttribute('style','display:block');
      erroremail = true;
   }
}

handy = document.getElementsByName('handy')[0];
handy.onfocus = function () {
    this.setAttribute('style','background: white');
}
handy.onblur = function () {
  if (this.value.match(regexPhone)) {
      warnung5 = [];
      this.setAttribute('style','background: white');
      document.querySelector('.msg.handy').innerHTML = warnung5;
      document.querySelector('.msg.handy').setAttribute('style','display:none');
      errorhandy = false;
  } else {
      warnung5.splice(0, 1,'Bitte geben sie ihre Telefonnummer ein!');
      this.setAttribute('style','background:seashell');
      document.querySelector('.msg.handy').innerHTML = warnung5;
      document.querySelector('.msg.handy').setAttribute('style','display:block');
      errorhandy = true;
  }
}


document.querySelector('#Test').onclick = function () {
   if(document.getElementById('nachhilfe geben').checked) {
      nachhilfe = "1";
   }
   else if(document.getElementById('nachhilfe nehmen').checked) {
      nachhilfe = "0";
   }
   var zeiten = document.getElementsByName("Zeiten");  
   var checkboxes;
   let checkitem = "";
   let berechnung = "";
      for (let i=0, inum=zeiten.length; i<inum; i++) { 
         checkboxes = zeiten[i];
         if (checkboxes.checked === true) {
            checkitem += checkboxes.id + ";";
            berechnung += checkboxes.value;
         }
      }
   
   Zeiten = checkitem.substr(0,checkitem.length-1);

   /*if(zahlen.length>berechnung.length){
      document.querySelector(".msg.Zeiten").innerHTML = 'Bitte wählen sie mindestens so viele Zeiten aus wie sie Fächer ausgewählt haben!';
   }
   else {
      document.querySelector(".msg.Zeiten").innerHTML = '';
   }*/
   

   if(document.getElementById('gruppennachhilfe').checked) {
      Anzahl = "1";
   }
   else if(document.getElementById('einzelnachhilfe').checked) {
      Anzahl = "0";
   }
   vorname.toString()
   nachname.toString()
   klasse.toString()
   console.log(vorname.value + " " + nachname.value + ":" + klasse.value + ":" + mail.value + ":" + handy.value + ":" + nachhilfe + ":" + fächer + ":" + Zeiten + ":" + Anzahl + ":" + bemerkungen.value);
   }

   var  myform = document.getElementById('save');
   myform.addEventListener('submit', (e) => {
      warnung1.toString()
      warnung2.toString()
      warnung3.toString()
      warnung4.toString()
      warnung5.toString()
      warnungen = warnung1 + warnung2 + warnung3 + warnung4 + warnung5
      if(warnungen.length > 0){
      e.preventDefault();
      }
   })
