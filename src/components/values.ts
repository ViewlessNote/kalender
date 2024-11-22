import {ref} from "vue";
function StandartEndTime(){
    let newDay = new Date()
    newDay.setMinutes(newDay.getMinutes() - newDay.getTimezoneOffset() + 60);
    return newDay.toISOString().slice(0, 16);
}
let compareDate;
let today = new Date();
let deadline = new Date();
deadline.setMinutes(deadline.getMinutes() - deadline.getTimezoneOffset());
compareDate = deadline.toISOString().slice(0, 16);

export let arr = ref([]);
export let ref1 = ref({
    id: 0,
    name: "",
    Details: "",
    Start: compareDate,
    Ende: StandartEndTime(),
    Aufgabe: false,
    Aktiv:false
})

export function usearr(){
    return arr
}
