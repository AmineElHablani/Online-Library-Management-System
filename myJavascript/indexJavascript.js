/*function randomQuote(table){
    let index = Math.floor(Math.random() * table.length);
    let quoteText = document.getElementById("quoteText");
    let quoteTitle = document.getElementById("quoteTitle");
    quoteText.innerText = table[index].Quote;
    quoteTitle.innerText = table[index].Category;
}*/



function randomQuote(table){
    let index = Math.floor(Math.random() * table.length);
    let quoteText = document.getElementById("quoteText");
    let quoteTitle = document.getElementById("quoteTitle");
    let quote ="";
    let title ="";
    for(let i =0; i <table[index].Quote.length;i++){
        setTimeout(function() {
            quote += table[index].Quote[i];
            quoteText.innerText = quote +"|";
            if( i == table[index].Quote.length -1){
                quoteText.innerText = table[index].Quote;

                //write title
                for(let j=0;j<table[index].Category.length ;j++){
                    setTimeout(function () {
                        title += table[index].Category[j];
                        quoteTitle.innerText = title +"|";
                        if(j == table[index].Category.length -1){
                                //quoteText.innerText = table[index].Quote;
                                quoteTitle.innerText = table[index].Category;
                        }
                    }, j*60 )
                }
                
            }
        }, i*60); // Delay each iteration by i seconds
    }
}



function hoverAchievements(element){
        element.style.backgroundColor = "white";
        element.style.color = "black";
        if(element.children[1].children[1].innerText == "Reviews"){
            element.children[0].children[0].src = "images/reviews_black.png";

        }else if(element.children[1].children[1].innerText == "Categories"){
            element.children[0].children[0].src = "images/category_black.png";

        }else if(element.children[1].children[1].innerText == "Books"){
            element.children[0].children[0].src = "images/books_black.png";
        }else{
            element.children[0].children[0].src = "images/users_black.png";
        }
}

function outAchievements(element){
        element.style.backgroundColor = "";
        element.style.color = "white";
        element.style.borderRadius="25px";
        element.style.paddingBottom="5px";

        if(element.children[1].children[1].innerText == "Reviews"){
            element.children[0].children[0].src = "images/reviews_color.png";

        }else if(element.children[1].children[1].innerText == "Categories"){
            element.children[0].children[0].src = "images/category_color.png";

        }else if(element.children[1].children[1].innerText== "Books"){
            element.children[0].children[0].src = "images/books_color.png";
        }else{
            element.children[0].children[0].src = "images/users_color.png";
        }
}


function loadNumbers() {
    let users = document.getElementById("numberUsers");
    let books = document.getElementById("numberBooks");
    let categories = document.getElementById("numberCategory");
    let reviews = document.getElementById("numberReviews");

    //verification if it is the first load 
    let status = document.getElementById("isFirstLoad")
    if(status.innerText=="this is the First Load"){
        status.innerText="not the first load"
        for (let i = 0; i <= 1000; i++) {
            setTimeout(function() {
                users.innerText = i;
            }, i*2.5); // Delay each iteration by i seconds
        }
        for (let i = 0; i <= 1000; i++) {
            setTimeout(function() {
                books.innerText = i;
            }, i*2.5); // Delay each iteration by i seconds
        }
        for (let i = 0; i <= 1000; i++) {
            setTimeout(function() {
                categories.innerText = i;
            }, i*2.5); // Delay each iteration by i seconds
        }
        for (let i = 0; i <= 1000; i++) {
            setTimeout(function() {
                reviews.innerText = i;
            }, i*2.5); // Delay each iteration by i seconds
        }
    }
  }


function selectedTopRated(element){
    //reset all
    allElements = document.getElementsByClassName("topBook");
    for(let i =0; i < allElements.length;i++){
        allElements[i].style.backgroundColor = "rgba(0, 0, 0, 0.696)";
    }

    //set selected element 
    element.style.backgroundColor = "rgba(255, 255, 255, 0.455)";
    

    //change the big template 
    let image = document.getElementById("imgTemplate");
    let title =document.getElementById("titleTemplate");
    let category =document.getElementById("categoryTemplate");
    let price =document.getElementById("priceTemplate");
    let author =document.getElementById("authorTemplate");
    let divImage = document.getElementById("divTitleTemplate");
    let showDetails = document.getElementById("show-details");

    //get new values from the selected item
    let newImage = element.children[0].children[0].src;
    //let newTitle = element.querySelector("h1");
    console.log(element)
    let newTitle = element.children[1].children[0].children[0].innerText
    let newAuthor = element.children[1].children[0].children[1].innerText
    let newCategory = element.children[1].children[0].children[2].innerText
    let newPrice = element.children[1].children[0].children[3].innerText
    let link = element.children[1].children[0].children[4].innerText


    //Affect the new values 
    image.src = newImage;
    title.innerText =newTitle;
    category.innerText = newCategory;
    price.innerText = newPrice;
    author.innerText = newAuthor;
    divImage.setAttribute("Title",newTitle);
    showDetails.href= "produit.php?isbn="+link;
    console.log("showDetails");

}



function line(element){
    console.log(element);

    if(element.children[0].children[0].innerText == "first time"){
        element.children[0].children[0].innerText ="not the first load";
        for(let i = 0; i <= 100; i++){
            setTimeout(function(){
                element.children[0].style.height= `${i}%`;
                console.log(`${i} %`);
            },i*10)
        }
    } 
}

function DisplayFilter(element){
    if(element.nextElementSibling.style.display == "none"){
        element.nextElementSibling.style.display ="";
    }else{
        element.nextElementSibling.style.display ="none";
    }
}


function testFilter(element){
    console.log(element.value)
}


function seeMore(){
    let descriptionDiv = document.getElementById("description");
    let divHeight= descriptionDiv.scrollHeight;
    let seeMore = descriptionDiv.children[2];
    let descriptionTextDiv = descriptionDiv.children[1]
    let descriptionText = descriptionDiv.children[1].children[0]
    console.log(descriptionText)
    console.log(descriptionTextDiv)
    let textHeight= descriptionText.scrollHeight
    
    console.log("textHeight"+textHeight)
    console.log("descriptionText"+descriptionText)
    console.log("descriptionDivHeight"+descriptionDiv.scrollHeight)
    
    console.log("divHeight"+divHeight);
    if(textHeight > 380){
        seeMore.style.display ='block';
        //descriptionText.style.height = "160px";
    }else{
        //descriptionText.style.height = textHeight;
        seeMore.style.display ='none';
    }
}

function clickedSeeMore(button){
    let parentDiv = document.getElementById("Parent-Description");
    let parentHeight = parentDiv.scrollHeight;
    console.log("parent :"+parentHeight)

    let content = document.getElementById("description")
    let contentHeight = content.scrollHeight
    console.log("content"+contentHeight)
    
    let descriptionDiv = document.getElementById("description-Div")
    let descriptionText= descriptionDiv.children[0]
    let textHeight = descriptionText.scrollHeight
    
    console.log("textHeight"+textHeight)
    console.log(descriptionText)
    console.log(button.innerText)
    
    console.log("descriptionDiv"+descriptionDiv.scrollHeight)
    if(button.innerText == "see more"){
        console.log("done")
        parentDiv.style.height=`${textHeight + 380}px`
        console.log(descriptionDiv.style.overflow)
        descriptionDiv.style.overflow="visible"
        descriptionDiv.style.height=`${textHeight}px`
        //parentDiv.style.height="10000px";
        console.log(parentDiv.height)
        console.log(descriptionText.style.overflow)

        button.innerText = "see less"
    }else{
        button.innerText = "see more"
        parentDiv.style.height="600px"
        descriptionDiv.style.height="160px"
        //
        descriptionDiv.style.overflow="hidden";
        descriptionDiv.style.textOverflow="ellipsis"
        descriptionDiv.style.display = '-webkit-box';
        descriptionDiv.style.webkitLineClamp = '6'; // Limit the content to 6 lines
        descriptionDiv.style.webkitBoxOrient = 'vertical';


        console.log(descriptionText.style.overflow)

    }
}