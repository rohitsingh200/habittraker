let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();

async function addHabit(){
let task=document.getElementById("task").value;
let date=new Date().toISOString().split("T")[0];
await fetch("/addHabit",{method:"POST",headers:{'Content-Type':'application/json'},
body:JSON.stringify({task,date,completed:1})});
loadHabits();
}

async function loadHabits(){
let res=await fetch("/getHabits");
let data=await res.json();

let calendar=document.getElementById("calendar");
calendar.innerHTML="";

let days=new Date(currentYear,currentMonth+1,0).getDate();
let streak=0;

for(let i=1;i<=days;i++){
let dayDiv=document.createElement("div");
dayDiv.className="day";
dayDiv.innerText=i;

let dateStr=`${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(i).padStart(2,'0')}`;

let completed=data.find(d=>d.date===dateStr);

if(completed){
let dot=document.createElement("div");
dot.className="dot white";
dayDiv.appendChild(dot);
streak++;
}

let todayDate=new Date();
if(i===todayDate.getDate() && currentMonth===todayDate.getMonth()){
let dot=document.createElement("div");
dot.className="dot red";
dayDiv.appendChild(dot);
}

calendar.appendChild(dayDiv);
}

document.getElementById("streak").innerText=streak;

new Chart(document.getElementById("chart"),{
type:"line",
data:{
labels:["Habits"],
datasets:[{label:"Completed",
data:[data.length]}]
}
});
}

loadHabits();
