<script setup>
import {ref, watch} from "vue";

const arr = ref([]);
const today = new Date();
var now_date = (today.getFullYear() + '-' + (today.getMonth()+1) + '-' + FormatDay());
const ref1 = ref({
  name: "",
  Start: new Date(),
  Ende: new Date()
})
function btnSave() {
     if(!validateDate(window.localStorage.getItem("StorageForm"))){
       return 0
     }
  arr.value.push(window.localStorage.getItem("StorageForm"));
  console.log(arr);
  window.localStorage.setItem("ArrLocalStorage", JSON.stringify(arr.value));


}

function FormatDay(){
  if(today.getDate() < 10 ){
    return '0'+today.getDate()
  }
  return today.getDate()
}

const StorageForm = window.localStorage.getItem("StorageForm");
const ArrLocalStorage = window.localStorage.getItem("arr");
watch(ref1, val => {window.localStorage.setItem("StorageForm", JSON.stringify(val));
},{deep:true});

addEventListener("submit", btnSave);


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
        if(Start === OStart || Ende === OEnde){
          alert("Deine eingegebene Start/Ende zeit ist schon belegt")
          return false;
        }else {console.log(Start + OStart);}
        if (Ende < OStart && Ende > OEnde){
          alert("Zeitraum schon belegt")
          return false;
        }
        if (Start < OStart && Start > OEnde){
          alert("Zeotraum schon belegt")
          return false;
        }
        if (Start < OStart && Ende > OEnde){
          alert("Zeotraum schon belegt")
          return false;
        }
      }
      return true;

    }





</script>

<template>
  <h1>Erstelle einen Kalender Eintrage {{now_date}}</h1>
  <form v-on:submit.prevent="">
  <input
  v-model="ref1.name"
  placeholder="Name"
  type="text"
  required
  />

  <input
      v-model="ref1.Start"
      placeholder="Datum"
      type="datetime-local"
      min=2024-11-04T12:01
      max={{JSON.parse(StorageForm).Ende}}
      required
  />

  <input
      v-model="ref1.Ende"
      type="datetime-local"
      min={{JSON.parse(StorageForm).Start}}
      required
  />
    <button type="submit" >Save</button>

  </form>

  <ul v-for="x in arr" key="{{x}}">
    <li>{{JSON.parse(x).name}} Start:{{JSON.parse(x).Start}} Ende:{{JSON.parse(x).Ende}}</li>

  </ul>

</template>

<style scoped>



</style>
