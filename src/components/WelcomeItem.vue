<script setup>
import {ref} from "vue";

const dayNames = ["Mon", "Tues", "Wed", "Thurs", "Fri"];
let today = new Date();
let deadline = new Date();
deadline.setMinutes(deadline.getMinutes() - deadline.getTimezoneOffset());
let compareDate = deadline.toISOString().slice(0, 16);

let day;
const arr = ref([]);
const ref1 = ref({
  id: 0,
  name: "",
  Details: "",
  Start: compareDate,
  Ende: compareDate,
  aufgabe: false,
  aktiv:false
})
function fetchDay(){
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
          let S = new Date(Termine[i].Start)
          let E = new Date(Termine[i].Ende)
          E.toISOString().slice(0,16)
          S.toISOString().slice(0,16)
          Termine[i].Start = S
          Termine[i].Ende = E
          arr.value.push(JSON.stringify(Termine[i]))
        }
        return Termine;
      })
}


</script>
<template>
  <div class="calendar">
    <div class="timeline">
      <div class="spacer"></div>
      <div class="time-marker">8:00 </div>
      <div class="time-marker">9:00 </div>
      <div class="time-marker">10:00 </div>
      <div class="time-marker">11:00 </div>
      <div class="time-marker">12:00 </div>
      <div class="time-marker">13:00 </div>
      <div class="time-marker">14:00 </div>
      <div class="time-marker">15:00 </div>
      <div class="time-marker">16:00 </div>
      <div class="time-marker">17:00 </div>
    </div>
    <div class="days">
      <div v-for="(day, index) in 5" :key="index" :class="['day', dayNames[index]]">
        <div class="date">
          <p class="date-num"></p>
          <p class="date-day">{{dayNames[index]}}</p>
        </div>
        <div class="events">
          <div class="event start-120 end-300 securities">
            <p class="Beispiel Event">Stan-ley</p>
            <p class="time">9:40 - 12:50</p>
          </div>
        </div>
  </div>
    </div>
  </div>
</template>


<style>
:root {
  --color-text: #fffcfc;
  --numDays: 5;
  --numHours: 600;
  --numMinuts: 60;
  --timeHeight: 0.9px;
  --timeLine:55px;
  --calBgColor: #dcdcdc;
  --eventBorderColor: #eadcde;
  --eventColor1: #aaa2a2;
  --eventColor2: #fafaa3;
  --eventColor3: #e2f8ff;
  --eventColor4: #d1ffe6;

}

.calendar {
  display: grid;
  gap: 10px;
  grid-template-columns: auto 1fr;
  margin: 2rem;
}

.timeline {
  display: grid;
  grid-template-rows: repeat(var(--numHours), var(--timeLine));
  color: #70a6fd;
}

.days {

  display: grid;
  grid-column: 2;
  gap: 5px;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
}

.events {
  display: grid;
  grid-template-rows: repeat(var(--numHours), var(--timeHeight));
  border-radius: 5px;
  background: var(--calBgColor);
}

/*Event ´Timings*/

.start-120 {
  grid-row-start: 120;
}
.end-300 {
  grid-row-end: 300;
}

// Event

.title {
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.event {
  border: 1px solid var(--eventBorderColor);
  border-radius: 5px;
  padding: 0.5rem;
  margin: 0 0.5rem;
  background: white;
}

.space,
.date {
  height: 60px
}

// Global / Etc

body {
  font-family: system-ui, sans-serif;
}
.event{
  background-color: #70a6fd;
}

.date {
  display: flex;
  gap: 1em;
}

.date-num {
  font-size: 3rem;
  font-weight: 600;
  display: inline;
}

.date-day {
  display: inline;
  font-size: 3rem;
  font-weight: 100;
}
</style>