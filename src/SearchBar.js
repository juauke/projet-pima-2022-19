import React from "react";


  
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
      setSearchVal(e.target.value);
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