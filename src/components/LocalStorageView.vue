<script setup>
import {ref, watch} from "vue";



let today = new Date();
const deadline = new Date();
deadline.setMinutes(deadline.getMinutes() - deadline.getTimezoneOffset());
const compareDate = deadline.toISOString().slice(0, 16);

const DayStart = "8:00"
const DayEnd = "18:00"

const StorageForm = window.localStorage.getItem("StorageForm");
const ArrLocalStorage = window.localStorage.getItem("arr");
const arrAufgaben = ref([]);
const arr = ref([]);
const ref1 = ref({
  name: "",
  Start: new Date(),
  Ende: new Date(),
  Aufgaben: false,
  Details: ""
})
const Aufgabenref = ref({
  name: "",
  DeadLine: compareDate,
  TimeItTakes: 0,
  Details: ""
})

const now_date = (today.getFullYear() + '-' + (today.getMonth()+1) + '-' + FormatDay());

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
  arrAufgaben.value.push(window.localStorage.getItem("AufgabenForm"));
  parseAufgabenIntoEvents()
}

function genEndDate(TiT){
  var items = TiT.split(":");
  var hours = Number(items[0]);
  var minutes = Number(items[1]);
  var Time = hours * 60 + minutes;
  let date = new Date()
  return new Date(date.getTime()+Time*60000)
}

function parseAufgabenIntoEvents(){
  for(let item of arrAufgaben.value){
   let val = JSON.parse(item)

    ref1.value.name = val.name;
    ref1.value.Start = new Date(compareDate);
    ref1.value.Ende =  genEndDate(val.TimeItTakes);
    ref1.value.Aufgaben = val.Aufgaben;
    ref1.value.Details = val.Details;
    console.log(ref1)
  }
}

watch(ref1, val => {window.localStorage.setItem("StorageForm", JSON.stringify(val));
},{deep:true});




function validateDate(StrageForm) {
  const Start = JSON.parse(StrageForm).Start;
  const Ende = JSON.parse(StrageForm).Ende;

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
    <li>{{JSON.parse(x).name}} Start:{{JSON.parse(x).Start}} Ende:{{JSON.parse(x).Ende}}</li>

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
