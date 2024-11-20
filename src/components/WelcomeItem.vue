<script setup>

import {ref} from "vue";

const dayNames = ["Mon", "Tues", "Wed", "Thurs", "Fri"];
let today = new Date();
let deadline = new Date();
deadline.setMinutes(deadline.getMinutes() - deadline.getTimezoneOffset());
let compareDate = deadline.toISOString().slice(0, 16);

let day;
let arrT = ref([[]]);
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

function ParseEventsIntoWeek(){
  updateArr();
  arrT.value = [[],[],[],[],[]];
  for (let i = 0; i < arr.value.length; i++){
    console.log("Logging: " + JSON.parse(arr.value[i]).name)
    arrT.value[GetDayOfWeek(JSON.parse(arr.value[i]).Start)-1].push(arr.value[i])
  }
}
function ConvertTimeToMinuts(s){
  s = s.slice(11,16);
    const [hours, minutes] = s.split(':').map(Number);
    let time = ((hours * 60) + minutes) - 480;
  if (time < 0){
    time = 0;
  }
    return time;
}
function GetDayOfWeek(date){
  const d = new Date(date);
  return d.getDay();
}
function updateArr(){
  arr.value = JSON.parse(window.localStorage.getItem("ArrLocalStorage"));
  console.log("UpdateArr: "+arr.value)
}

addEventListener("mousedown", ParseEventsIntoWeek)

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
          <div v-for="event in arrT[index]" :class= "['event']" :style="{'grid-row-start': ConvertTimeToMinuts(JSON.parse(event).Start), 'grid-row-end':ConvertTimeToMinuts(JSON.parse(event).Ende)}">
           <div class="wraper">
             <div>{{JSON.parse(event).name}}</div><button>X</button>
             <div>{{JSON.parse(event).Start.slice(11,16)}} - {{JSON.parse(event).Ende.slice(11,16)}}</div>
           </div>
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
  --timeLine:58.8px;
  --calBgColor: #dcdcdc;
  --eventBorderColor: #eadcde;
  --eventColor1: #aaa2a2;
  --eventColor2: #fafaa3;
  --eventColor3: #e2f8ff;
  --eventColor4: #d1ffe6;
  --timline1: 11;
}


.calendar {
  display: grid;
  gap: 10px;
  grid-template-columns: auto 1fr;
  margin: 2rem;
}

.timeline {
  display: grid;
  grid-template-rows: repeat(var(--timline1), var(--timeLine));
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