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
  Aufgabe: false,
  aktiv:false
})
fetchall()
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

function fetchDay() {
  arr.value = [];
  let Termine
  fetch('http://127.0.0.1:8000/Termine', {
    method: 'GET',
  })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        Termine = JSON.parse(data)
        console.log(Termine.length)
        for (let i = 0; i < Termine.length; i++) {
          let S = new Date(Termine[i].Start)
          let E = new Date(Termine[i].Ende)
          E.toISOString().slice(0, 16)
          S.toISOString().slice(0, 16)
          Termine[i].Start = S
          Termine[i].Ende = E
          arr.value.push(JSON.stringify(Termine[i]))
        }
        return Termine;
      })
}
function ConvertTimeToMinuts(s){
  s = s.slice(11,16);
    const [hours, minutes] = s.split(':').map(Number);
    let time = ((hours * 60) + minutes) - 420;
    console.log("Time in Minuts "+ time)
    return time;
}
function GetDayOfWeek(date){
  const d = new Date(date);
  return d.getDay();
}



</script>

<script>
/*
const dayNames = ["Mon", "Tues", "Wed", "Thurs", "Fri"];
 function EventManager() {

//This Function ads the Events as a Visual
  for (let i = 0; i < dayNames.length; i++) {
    var iDiv = document.createElement('div');
    var P1 = document.createElement("p")
    P1.textContent = "From 18:00 to 20:00"
    iDiv.textContent = "New Event";
    iDiv.className = 'event start-120 end-300 securities';
    iDiv.append(P1)
    document.getElementsByClassName("events " + dayNames[i])[0].append(iDiv)
  }
}
document.addEventListener("DOMContentLoaded", function(){
  EventManager();
});
*/
</script>

<template>
  <div>
  <div class="calendar">
    <div class="timeline">
      <div class="spacer"></div>
      <div class="time-marker">8:00</div>
      <div class="time-marker">9:00 </div>
      <div class="time-marker">10:00 </div>
      <div class="time-marker">11:00 </div>
      <div class="time-marker">12:00 </div>
      <div class="time-marker">13:00 </div>
      <div class="time-marker">14:00 </div>
      <div class="time-marker">15:00 </div>
      <div class="time-marker">16:00 </div>
      <div class="time-marker">17:00 </div>
      <div class="time-marker">18:00 </div>
    </div>
    <div class="days">
      <div v-for="(day, index) in 5" :key="index" :class="['day', dayNames[index]]">
        <div class="date">
          <p class="date-num"></p>
          <p class="date-day">{{dayNames[index]}} </p>
        </div>
        <div :class="['events', dayNames[index]]" >
          <div v-for="event in arr"  :class= "['event']" :style="{'grid-row-start': ConvertTimeToMinuts(JSON.parse(event).Start), 'grid-row-end':ConvertTimeToMinuts(JSON.parse(event).Ende)}">
            <div>{{JSON.parse(event).name}}</div>
            <div>{{JSON.parse(event).Start}} - {{JSON.parse(event).Ende}}"</div>
          </div>
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
  --timeHeight: 1px;
  --timeLine:58px;
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