<script setup>
import {ref, watch} from "vue";

const arr = ref([]);
const ref1 = ref({
  name: "",
  DeadLine: new Date()
})
function btnSave() {
  if(!validateDate(window.localStorage.getItem("AufgabenForm"))){
    return 0
  }
  arr.value.push(window.localStorage.getItem("AufgabenForm"));
  console.log(arr);
  window.localStorage.setItem("ArrLocalStorage", JSON.stringify(arr.value));
}

function FormatDay(){
  if(today.getDate() < 10 ){
    return '0'+today.getDate()
  }
  return today.getDate()
}

const AufgabenForm = window.localStorage.getItem("AufgabenForm");
const AufgabenArr = window.localStorage.getItem("arr");
watch(ref1, val => {window.localStorage.setItem("AufgabenForm", JSON.stringify(val));
},{deep:true});

addEventListener("submit", btnSave);

/*
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
*/




</script>

<template>
  <h1>Erstelle eine Aufgabe </h1>
  <form v-on:submit.prevent="">
    <input
        v-model="ref1.name"
        placeholder="Name"
        type="text"
        required
    />

    <div>Deadline (*Optional)</div>
    <input
        v-model="ref1.DeadLine"
        type="datetime-local"
    />
    <button type="submit" >Save</button>

  </form>

  <ul v-for="x in arr" key="{{x}}">
    <li> Aufgaben: {{JSON.parse(x).name}} Start:{{JSON.parse(x).DeadLine}}</li>

  </ul>

</template>

<style scoped>



</style>
