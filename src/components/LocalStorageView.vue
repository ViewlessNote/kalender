<script setup>
import {ref, watch} from "vue";

let today = new Date();
let deadline = new Date();
let compareDate = deadline.toISOString().slice(0, 16);
function getTimeandDate(){
  deadline = new Date();
  deadline.setMinutes(deadline.getMinutes() - deadline.getTimezoneOffset());
  compareDate = deadline.toISOString().slice(0, 16);
  today  = new Date();
  today = today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
  console.log("Time Now is: "+today);
  return today
}
const DayStart = "8:00"
const DayEnd = "18:00"
const MaxAufgabenPerDay = 3;
let AufgabenToday = 0;

const StorageForm = window.localStorage.getItem("StorageForm");
const ArrLocalStorage = window.localStorage.getItem("arr");
const arrAufgaben = ref([]);
const arr = ref([]);
const ref1 = ref({
  name: "",
  Start: new Date(),
  Ende: new Date(),
  Aufgaben: false,
  AufgabeAktiv:false,
  Details: ""
})
const Aufgabenref = ref({
  name: "",
  DeadLine: compareDate,
  TimeItTakes: 0,
  Details: ""
})

setInterval(()=> {
  getTimeandDate();
 sortEvents();
}, 1000*30);

const now_date = (today.getFullYear() + '-' + (today.getMonth()+1) + '-' + FormatDay());

function sortEvents() {
  for (let item of arr.value) {
    item = JSON.parse(item);
    if (item.AufgabeAktiv === true ){
      if (item.Start < compareDate){
        if(FindPlaceInKalender(JSON.stringify(item))){
          console.log("NoDateFound")
        }
      }
    }

  }
}

function btnSave() {
  console.log("2024-11-07T11:00");
  console.log(compareDate);
     if(!validateDate(window.localStorage.getItem("StorageForm"))){
       return 0
     }
  arr.value.push(window.localStorage.getItem("StorageForm"));
  window.localStorage.setItem("ArrLocalStorage", JSON.stringify(arr.value));
}

function FormatDay(){
  if(today.getDate() < 10 ){
    return '0'+today.getDate()
  }
  return today.getDate()
}

//Getting data from Aufgabe.vue
addEventListener("submit", UpdateData)
function UpdateData(){
  parseAufgabenIntoEventFormat(window.localStorage.getItem("AufgabenForm"))
  console.log(window.localStorage.getItem("AufgabenForm"))
}

function genEndDate(TiT){
  var items = TiT.split(":");
  var hours = Number(items[0]);
  var minutes = Number(items[1]);
  var Time = hours * 60 + minutes;
  let date = new Date()
  return new Date(date.getTime()+Time*60000)
}

function parseAufgabenIntoEventFormat(item){
   let val = JSON.parse(item)
  let Start = today.toISOString().slice(0, 16);
  let Ende = new Date(genEndDate(val.TimeItTakes));
  Ende = Ende.toISOString().slice(0, 16);
    let newEintrag= ref1;
    newEintrag.value.name = val.name;
    newEintrag.value.Start = Start;
    newEintrag.value.Ende =  Ende;
    newEintrag.value.Aufgaben = true;
    newEintrag.value.Details = val.Details;
    newEintrag.value.AufgabeAktiv = true;
    console.log(newEintrag.value)
    FindPlaceInKalender(JSON.stringify(newEintrag.value));
  }

function FindPlaceInKalender(item){
  console.log(item)
  while(!validateDate(item)){
    let item2 = JSON.parse(item)
    let NStart = new Date(item2.Start);
    let NEnde = new Date(item2.Ende);
    item2.Start = NStart.getTime() + 600000;
    item2.Ende = NEnde.getTime() + 600000;
    console.log(item)
    item = JSON.stringify(item2)
  }
  arr.value.push(item);
  return true;
}

watch(ref1, val => {window.localStorage.setItem("StorageForm", JSON.stringify(val));
},{deep:true});




function validateDate(itemForm) {
  console.log(itemForm);
  const Start = JSON.parse(itemForm).Start;
  const Ende = JSON.parse(itemForm).Ende;

      if(Ende < Start){
        alert("Das Ende des Termins Liegt vor seinem Startpunkt")
        console.log("Alert")
        return false;
      }

      for (let item of arr.value){
        let OStart =JSON.parse(item).Start;
        let OEnde =JSON.parse(item).Ende;
        if (Start > OStart){
          console.log("Start ist Gröser als O Start")
        }
        if(Start === OStart || Ende === OEnde){
          alert("Deine eingegebene Start/Ende zeit ist schon belegt")
          return false;
        }
        if (Ende > OStart && Ende < OEnde){
          alert("Zeitraum schon belegt (Ende drin)")
          return false;
        }
        if (Start > OStart && Start < OEnde){
          alert("Zeitraum schon belegt (Strat drin)")
          return false;
        }

      }
      return true;

    }

</script>

<template>
  <h1>Erstelle einen Kalender Eintrage {{now_date}}</h1>
  <form v-on:submit.prevent="" @submit="btnSave">
  <input
  v-model="ref1.name"
  placeholder="Name"
  type="text"
  required
  />
    <div>Von:</div>

  <input
      id="StartDateInput"
      v-model="ref1.Start"
      placeholder="Datum"
      type="datetime-local"
      min={{compareDate}}
      required
  />
    <div>Bis:</div>
  <input
      v-model="ref1.Ende"
      type="datetime-local"
      required
  />
    <button type="submit" >Save</button>

  </form>

  <ul v-for="x in arr" key="{{x}}">
    <li>{{JSON.parse(x).name}}</li> <li>Start:{{JSON.parse(x).Start}}</li> <li>Ende:{{JSON.parse(x).Ende}}</li>

  </ul>

</template>

<style scoped>
form {

}
input{
  flex: 1;
  padding: 2px;
  border: 1px dotted black;
}

</style>
