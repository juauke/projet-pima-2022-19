import React from "react";
import Jquery from "jquery";

  
/**
 * Create the SearchBar
 */
 function SearchBar(props) {
    //let influenceurs=[];
    /*An additional function to work with the new format of influenceurs*/
    function find_name(influenceur_pseudo){
      let influenceurs = [
        ['Hauchard', 'Iov', 'Odzierejko', 'Thavaud', 'Delapart'], 
        ['SqueeZie', 'Cyprien', 'Natoo', 'Norman', 'Tibo InShape']
      ];
      let i = 0;
      let name_found = 0;
      while (name_found == 0){
        if (influenceurs[1][i] == influenceur_pseudo){
          name_found = 1;
        }
        else{
          i = i + 1;
        }
      }
      return influenceurs[0][i];
    }
  
    const [searchVal, setSearchVal] = React.useState('');
    const handleInput= (e) => {
      Jquery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Jquery('meta[name="csrf-token"]').attr('content')
        }
    });
      setSearchVal(e.target.value);
      console.log(e.target.value);
      influenceurs=[];
      Jquery.ajax({
         type: 'POST',
         url:'../PHP/barre_recherche.php',
          data : {"name":e.target.value}
      }).done(function (data) {
          if (data=='1'){
            Jquery.ajax({
              type: 'GET',
              url:'../PHP/Connexion_API/Connect_api_youtube.php',
              async: false,
               data : {"name":e.target.value},
           success:function (data) {
            var len=data.length;
            var l=JSON.parse(data);
            console.log(data);
            if(data!="null"){
            influenceurs.push([l.name,l.pop,l.sub,l.vc,l.images,l.url]);}
            //alert(influenceurs);
           },
           error : function(data,textStatus,errorThrown){
            alert(errorThrown);
            alert(textStatus);
           }});        
           Jquery.ajax({
            type: 'GET',
            url:'../PHP/Connexion_API/Connect_api_Spotify.php',
            async: false,
             data : {"name":e.target.value},
             success:function (data) {
              var l=JSON.parse(data);
              console.log(data);
              if(data!=null){
              influenceurs.push([l.name,l.pop,l.sub,l.vc,l.images,l.url]);}
                //influenceurs.push([data[i].name,data[i].pop,data[i].sub,data[i].vc,data[i].images])

              //alert(influenceurs);
             },
             error : function(data,textStatus,errorThrown){
              alert(errorThrown);
              alert(textStatus);
             }}); 
         Jquery.ajax({
          type: 'GET',
          url:'../PHP/Connexion_API/Connect_api_twitch.php',
          async: false,
           data : {"name":e.target.value},
           timeout : 10000000000,
       success:function (data) {
        var len=data.length;
        console.log(data);
        if(data!="NULL" && data !="Curl error: NULL" && data!=""){
          var l=JSON.parse(data);
          //console.log(l["name"]);
          influenceurs.push([l.channel,l.pop,l.sub,l.vc,l.images,l.url]);
        }
        //alert(influenceurs);
       },
       error : function(data,textStatus,errorThrown){
        alert(errorThrown);
        alert(textStatus);
       }}); 
       props.rerender();
       //alert(influenceurs);
          }
        else{
          if(data!=""){
          console.log(data);
          var data2=data.split(',');
          var arr=JSON.parse(data2);
          console.log(arr);
          arr.forEach(e=>influenceurs.push([e.username,e.nb_views,e.nb_subscribers,e.nb_videos,e.image,e.url]));}
          props.rerender();
          
        }
      })
      
     

    }
    
    const handleClearBtn = () => {
      setSearchVal('');
    }
    
    /*const filteredProducts = props.products.filter((product) => {

      return product.includes(searchVal);
    });*/
    
    return (
      <div className='research'>
        <div className='input-wrap'>
          <i className="fas fa-search"></i>
          <label 
            for="product-search" 
            id="input-label"
          >
            Product Search
          </label>
          <input 
            onChange={handleInput}
            value={searchVal}
            type="text" 
            name="product-search" 
            id="product-search" 
            placeholder="Search Influenceurs"
          />
          <i 
            onClick={handleClearBtn}
            className="fas fa-times"
          ></i>
        </div>
        <div className="results-wrap">
        </div>
      </div>
    );
  }

  export default SearchBar;
  export var influenceurs=[];