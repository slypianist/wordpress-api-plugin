// Declaration of variables
var pageSize =10 ;
var curPage = 1;
var providerData = [];
var totalRecord ;
var totalPages;
var category = '' ;
var search = '' ;
var category = '';
const noResult = 'No provider(s) list for this query. Please try another search term.';


 const showMsg =    document.getElementById('errorMsg');
 
const loader = document.getElementById('preloading');

const loaderSearch = document.getElementById('searchProgress');

const searchBut = document.getElementById('searchButton');

const tableShow = document.getElementById('listingTable');

document.getElementById("per_page").value = pageSize;

// Loaders Module

function showLoader(){
    loader.classList.add('show');
}

function hideLoader(){
    loader.classList.remove('show');
}

function showSearchLoader(){
    loaderSearch.classList.add('show')
}

function hideSearchLoader(){
    loaderSearch.classList.remove('show')
}

function hideTable(){
    tableShow.classList.add('show');
    
}

function showTable(){
    tableShow.classList.remove('show');
}

   
async function renderTable(p = 1) {
  //  search = item;
    const params = `page=${p}&size=${pageSize}&category=${category}&search=${search}`;
let baseUrl = '/wp-json/avon/avon-provider'+'?'+ params;
 // await getData();
 hideTable();
 showLoader();

  const response = await fetch(baseUrl);
  const provider = await response.json();
 
    providerData =(provider.data);
    totalRecord = (provider.totalrecords);
    pageSize = (provider.pageSize);
   
    totalPages = Math.ceil(totalRecord / pageSize);
   
   navigation();
 
 hideLoader();
 hideSearchLoader();
 searchBut.style.display = "block";
 showMsg.style.display = "none";
 showTable();


  if (p == 1) {
    prevButton.style.visibility = "hidden";
  } else {
    prevButton.style.visibility = "visible";
  }

  if (p == numPages()) {
    nextButton.style.visibility = "hidden";
  } else {
    nextButton.style.visibility = "visible";
  }

  // create html
  var avonProvider = "";
  if(providerData.length === 0){
      
  const showMsg =    document.getElementById('errorMsg');
  const msg = document.getElementById('msg');
  
  showMsg.style.display = "block";
  
  msg.innerHTML = noResult;
  
  }
  
  providerData.forEach(provider => {
    avonProvider += "<tr>";
    avonProvider += `<td> ${provider.name} </td>`;
    avonProvider += `<td> ${provider.providerClass}</td>`;
     "<tr>";
  });
  
  document.getElementById("data").innerHTML = avonProvider;
   
}


function previousPage() {
  if (curPage > 1) {
    curPage--;
     document.getElementById("text-sm").innerHTML = 'Page ' +  curPage + ' of '
+ totalPages + ' Page(s)';
//hideTable();
    renderTable(curPage);
  }
}

function nextPage() {
  if (curPage  < numPages()) {
      
      curPage++;
      console.log(curPage);
      document.getElementById("text-sm").innerHTML = 'Page ' +  curPage + ' of '
+ totalPages + ' Page(s)';
    //  hideTable();
    renderTable(curPage);
  }
  
}


 

renderTable();


 function numPages() {
     
  return Math.ceil(totalRecord/pageSize);
}



 document.querySelector('#searchButton').addEventListener('click', ()=>{
      search  = document.getElementById('user_input').value;
     category = document.getElementById('categoryPlan').value;
     showSearchLoader();
     searchBut.style.display = "none";
      console.log(category);
      
     
          renderTable(1,search);
     user_input.value = '';
     categoryPlan.selectedIndex = 0;
      
     
 });
 
 
 document.querySelector('#per_page').addEventListener('click', ()=>{
    pageSize = document.getElementById('per_page').value;
    console.log(pageSize);
    renderTable();
});


function navigation(){
  let nav =   document.getElementById("text-sm").innerHTML = 'Page ' +  curPage + ' of '
+ totalPages + ' Page(s)';
     
}

document.querySelector('#nextButton').addEventListener('click', nextPage, false);
document.querySelector('#prevButton').addEventListener('click', previousPage, false);



//Fetch Data from API

