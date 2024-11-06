<script setup>
import {ref, watch} from "vue";


var today = new Date();
const compareDate = (today.getFullYear() + '-' + (today.getMonth()+1) + '-' + getDate()+"T"+ today.getHours() + ":" + getMin());

const AufgabenForm = window.localStorage.getItem("AufgabenForm");
const AufgabenArr = window.localStorage.getItem("arr");
const arr = ref([]);
const ref1 = ref({
  name: "",
  DeadLine: compareDate,
  TimeItTakes: 0
})

function getDate(){
  if( today.getDate() < 10){
    return '0'+today.getDate()
  }
  return  today.getDate()
}
function getMin(){
  if( today.getMinutes() < 10){
    return '0'+today.getMinutes()
  }
  return  today.getMinutes()
}

function btnSaveAufgabe() {

  arr.value.push(window.localStorage.getItem("AufgabenForm"));
  window.localStorage.setItem("ArrLocalStorage", JSON.stringify(arr.value));

}



watch(ref1, val => {window.localStorage.setItem("AufgabenForm", JSON.stringify(val));
},{deep:true});


</script>

<template>
  <h1>Erstelle eine Aufgabe </h1>
  <form v-on:submit.prevent="" @submit="btnSaveAufgabe()">
    <input
        v-model="ref1.name"
        placeholder="Name"
        type="text"
        required
    />
    <div>Duration</div>
    <input
    v-model="ref1.TimeItTakes"
    placeholder="1:00"
    type="time"
    step="10."
    >

    <div>Deadline (*Optional)</div>
    <input
        id="DeadlineInput"
        v-model="ref1.DeadLine"
        type="datetime-local"
    />
    <button id="AufgabenSave" type="submit" >Save</button>

  </form>

  <ul v-for="x in arr" key="{{x}}">
    <li> Aufgaben: {{JSON.parse(x).name}} Deadline:{{JSON.parse(x).DeadLine}}</li>

  </ul>

</template>

<style scoped>



</style>
