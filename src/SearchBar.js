import React from "react";
import Jquery from "jquery";

  
/**
 * Create the SearchBar
 */
 function SearchBar(props) {

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
    
    const handleInput = (e) => {
      let influenceurs=[];
      setSearchVal(e.target.value);
      Jquery.ajax({
         type: 'POST',
         url:'../PHP/barre_recherche.php',
          data : {"name":e.target.value}
      }).done(function (data) {
        console.log(data);
          if (data=='1'){
            Jquery.ajax({
              type: 'POST',
              url:'../PHP/Connexion_API/Connect_api_youtube.php',
               data : {"name":e.target.value}
           }).done(function (data) {
            influenceurs.push(data);


           })
           Jquery.ajax({
            type: 'POST',
            url:'../PHP/Connexion_API/Connect_api_Spotify.php',
             data : {"name":e.target.value}
         }).done(function (data) {
          influenceurs.push(data);

         })
         Jquery.ajax({
          type: 'POST',
          url:'../PHP/Connexion_API//Connect_api_twitch.php',
           data : {"name":e.target.value}
       }).done(function (data) {
        influenceurs.push(data);
       })
          }
        else{
          
        }
      })

    }
    
    const handleClearBtn = () => {
      setSearchVal('');
    }
    
    const filteredProducts = props.products.filter((product) => {
      return product.includes(searchVal);
    });
    
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
          <ul>
            {filteredProducts.map((product) => {
              return <li key={product} className='list-item' onClick={  props.onClick}><a href='#'>{product}</a></li>
            })}
          </ul>
        </div>
      </div>
    );
  }

  export default SearchBar;
  export let influenceurs;