<script setup>
import {ref, watch} from "vue";

let today = new Date();
let deadline = new Date();
deadline.setMinutes(deadline.getMinutes() - deadline.getTimezoneOffset());
let compareDate = deadline.toISOString().slice(0, 16);

function CompareDateUpdate(){
  let newDay = new Date()
  newDay.setMinutes(newDay.getMinutes() - newDay.getTimezoneOffset());
  compareDate = newDay.toISOString().slice(0, 16);
  compareDate = compareDate +".000Z"
}

function StandartEndTime(){
  let newDay = new Date()
  newDay.setMinutes(newDay.getMinutes() - newDay.getTimezoneOffset() + 60);
  return newDay.toISOString().slice(0, 16);
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
  id: 0,
  name: "",
  Details: "",
  Start: compareDate,
  Ende: StandartEndTime(),
  Aufgabe: false,
  aktiv:false
})
const Aufgabenref = ref({
  name: "",
  DeadLine: compareDate,
  TimeItTakes: 0,
  Details: ""
})

setInterval(()=> {
  CompareDateUpdate()
 sortEvents();
}, 1000*10);

const now_date = (today.getFullYear() + '-' + (today.getMonth()+1) + '-' + FormatDay());
fetchall();
function fetchall(){
  arr.value = [];
  let Termine
  fetch('http://127.0.0.1:8000/Termine', {
    method: 'GET',
  })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
         Termine = JSON.parse(data)
        console.log(Termine.length)
        for (let i = 0; i < Termine.length; i++){
          let item2 = Termine[i]
          let NStart = new Date(item2.Start);
          let NEnde = new Date(item2.Ende);
          NStart.setMinutes(NStart.getMinutes() +1 );
          NEnde.setMinutes(NEnde.getMinutes()+1);
          item2.Start = NStart.toISOString().slice(0, 16);
          item2.Ende = NEnde.toISOString().slice(0, 16);
          Termine[i] = JSON.stringify(item2)
          arr.value.push(Termine[i])
        }
        return Termine;
      })
}
function sortEvents() {
  if (arr.value.length<1) {return}
  for (let i = 0; i <= arr.value.length-1; i++) {
    let item = JSON.parse(arr.value[i]);
    if (item.Ende < compareDate) {
     if (item.Aufgabe === true ){
      if (item.Start < compareDate){
        deleteFromDB(item.id)
        arr.value.splice(i, 1);
        if(FindPlaceInKalender(JSON.stringify(item))){
          console.log("DateFound")
        }
      }
    }
  }
  }
  arr.value.sort((x, y) => {
    return new Date(x.Start) > new Date(y.Start) ? 1 : -1})
}

function WriteToArray(newArrayItem){
  console.log("WriteToArray")
  JSON.parse(newArrayItem).id = arr.value.length;
  JSON.stringify(newArrayItem);
  arr.value.push(newArrayItem)
  console.log("Writing " + newArrayItem);
  fetch('http://127.0.0.1:8000/setTermin', {
    method: 'POST',
    body: newArrayItem
  })
      .then(response => console.log(response.json()))

  ref1.value.name = "";
  ref1.value.Start= compareDate;
  ref1.value.Ende= StandartEndTime();
  ref1.value.Aufgabe = false;
  ref1.value.aktiv=false;
  ref1.value.Details= "";
}


function btnSave() {
  console.log(compareDate);
     if(!validateDate(window.localStorage.getItem("StorageForm"))){
      alert("Wrong Input or date is occupied")
       return ;
     }
  WriteToArray(window.localStorage.getItem("StorageForm"));
  window.localStorage.setItem("ArrLocalStorage", JSON.stringify(arr.value));
  CheckAufAufgabe();
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
  let Data= window.localStorage.getItem("AufgabenForm");
  console.log(Data);
  if (JSON.parse(Data).name === ""){
    return
  }
  parseAufgabenIntoEventFormat(window.localStorage.getItem("AufgabenForm"))
  console.log(window.localStorage.getItem("AufgabenForm"));
  window.localStorage.setItem("AufgabenForm", JSON.stringify(""));

}

function genEndDate(TiT){
  let items = TiT.split(":");
  let hours = Number(items[0]);
  let minutes = Number(items[1]);
  let Time = hours * 60 + minutes;
  let date = new Date()
  date = date.setMinutes(date.getMinutes() - date.getTimezoneOffset())
  return new Date(date+Time*60000)
}

function parseAufgabenIntoEventFormat(item){
   let val = JSON.parse(item)
  let Start = compareDate;
  let Ende = new Date(genEndDate(val.TimeItTakes));
  Ende = Ende.toISOString().slice(0, 16);
    let newEintrag = ref1;
    newEintrag.value.name = val.name;
    newEintrag.value.Start = Start;
    newEintrag.value.Ende =  Ende;
    newEintrag.value.Aufgabe = true;
    newEintrag.value.Details = val.Details;
    newEintrag.value.aktiv = true;
    FindPlaceInKalender(JSON.stringify(newEintrag.value));

  }

function deleteFromDB(id){
  fetch('http://127.0.0.1:8000/Termin/'+id, {
    method: 'DELETE',
  })
      .then(function(response) {
        return response.json();
      })
}


function FindPlaceInKalender(item){

  while(!validateDate(item)){
    let item2 = JSON.parse(item)
    let NStart = new Date(item2.Start+"Z");
    let NEnde = new Date(item2.Ende+"Z");
    NStart.setMinutes(NStart.getMinutes() +1 );
    NEnde.setMinutes(NEnde.getMinutes()+1);
    if (NStart.getMinutes() > 59){
      NStart.setMinutes(0)
      NStart.setHours(NStart.getHours() +1)
      if (NStart.getHours() > 24){
        NStart.setHours(0)
        NStart.setDate(NStart.getDate()+1)
      }
    }
    item2.Start = NStart.toISOString().slice(0, 16);
    item2.Ende = NEnde.toISOString().slice(0, 16);
    item = JSON.stringify(item2)
  }
  WriteToArray(item);
  return true;
}

watch(ref1, val => {window.localStorage.setItem("StorageForm", JSON.stringify(val));
},{deep:true});



function validateDate(itemForm) {

  const Start = JSON.parse(itemForm).Start;
  const Ende = JSON.parse(itemForm).Ende;
  Start.slice(0,16);
  Ende.slice(0,16);

      if(Ende < Start){
        alert("Das Ende des Termins Liegt vor seinem Startpunkt")
        console.log("Alert")
        return false;
      }

      if (Start < compareDate){
        //Wenn eine aufgabe noch nicht abgehackt wurde
        console.log("Aufgabe nicht erledigt, sie wurde weiter geschoben")
        return false;
      }

      if(JSON.parse(itemForm).Aufgaben === true && JSON.parse(itemForm).Ende.slice(11,16) > "18:00Z000"){
        return false;
      }
      if(JSON.parse(itemForm).Aufgaben === true && JSON.parse(itemForm).Start.slice(11,16) < "08:00Z000"){
       return false;
      }

      for (let item of arr.value){
        let OStart =JSON.parse(item).Start;
        let OEnde =JSON.parse(item).Ende;
        if (Start > OStart){
          console.log("Start ist Gröser als O Start")
        }
        if(Start === OStart || Ende === OEnde){
          if (JSON.parse(item).Aufgaben === true && JSON.parse(itemForm).Aufgaben === false){
            arr.value.splice(JSON.parse(item).id-1, 1);
            deleteFromDB(JSON.parse(item).id);
            setTimeout(() =>{
              FindPlaceInKalender(item);
            },1)
          }else{return false;}
        }

        if (Ende > OStart && Ende < OEnde){
          if (JSON.parse(item).Aufgaben === true && JSON.parse(itemForm).Aufgaben === false){
            arr.value.splice(JSON.parse(item).id-1, 1);
            deleteFromDB(JSON.parse(item).id);
            setTimeout(() =>{
              FindPlaceInKalender(item);
            },1)
          }else{return false;}
        }
        if (Start > OStart && Start < OEnde){
          if (JSON.parse(item).Aufgaben === true && JSON.parse(itemForm).Aufgaben === false){
            arr.value.splice(JSON.parse(item).id-1, 1);
            deleteFromDB(JSON.parse(item).id);
            setTimeout(() =>{
              FindPlaceInKalender(item);
            },1)
          }else{return false;}
        }
      }
      return true;
    }
function CheckAufAufgabe(){
  for(let x of arr.value){
    document.getElementById(JSON.parse(x).id).checked = true;
  }
}

Date.prototype.getWeek = function() {
  var onejan = new Date(this.getFullYear(), 0, 1);
  return Math.ceil((((this - onejan) / 86400000) + onejan.getDay() + 1) / 7);
}

let weekNumber = (new Date()).getWeek();

var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

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
    <input
        v-model="ref1.Details"
        placeholder="Details"
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
    <button type="reset" @click="fetchall()" >Reload</button>
  </form>


  <ul  v-for="x in arr" key="{{x}}">
    <li>{{JSON.parse(x).name}}</li>
    <li>Start:{{JSON.parse(x).Start}}</li>
    <li>Ende:{{JSON.parse(x).Ende}}</li>
    <li> Aufgabe: <input id={{JSON.parse(x).id}} type="checkbox" ></li>
  </ul>

</template>

<style scoped>

</style>
