<script setup >
import {ref, watch} from "vue";

let deadline = new Date();
deadline.setMinutes(deadline.getMinutes() - deadline.getTimezoneOffset());
let compareDate = deadline.toISOString().slice(0, 16);

function CompareDateUpdate(){
  let newDay = new Date()
  newDay.setMinutes(newDay.getMinutes() - newDay.getTimezoneOffset());
  compareDate = newDay.toISOString().slice(0, 16);
}

function StandartEndTime(){
  let newDay = new Date()
  newDay.setMinutes(newDay.getMinutes() - newDay.getTimezoneOffset() + 60);
  return newDay.toISOString().slice(0, 16);
}
const AufgabenForm = window.localStorage.getItem("AufgabenForm");
const AufgabenArr = window.localStorage.getItem("arr");
const arr = ref([]);
const ref1 = ref({
  name: "",
  DeadLine: StandartEndTime(),
  TimeItTakes: "01:00",
  Details: "",
  Aufgaben: true
})

function btnSaveAufgabe() {

  arr.value.push(window.localStorage.getItem("AufgabenForm"));
  window.localStorage.setItem("ArrLocalStorage", JSON.stringify(arr.value));
  setTimeout(()=>{
    ref1.value.name = "";
    ref1.value.DeadLine = StandartEndTime();
    ref1.value.TimeItTakes = "01:00";
    ref1.value.Details = "";
    ref1.value.aufgabe = true},1)
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

    <input
        v-model="ref1.Details"
        placeholder="Details"
        type="text"
        required
    />
    <div>Duration</div>

    <input
        v-model="ref1.TimeItTakes"
        placeholder="1:00"
        type="time"
        step="10."
        value="00:00"
        max=8:00:00
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
