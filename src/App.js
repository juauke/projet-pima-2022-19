
import './App.css';
import React from 'react';

/* Function exported to render the page */

function App() {
  
  return (
        <MainContainer/>
  );
}

/**
 * 
 * @param {*} props (onClick, Page)
 * @returns A html button with the props.onClick onclick trigger and the props.Page text
 */

function MenuLink(props)
{
  return <button className='NavBarButton' onClick={props.onClick}>{props.Page}</button>;
}

/**
 * 
 */
class SocialNetworkButton extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <img src={this.props.Image} className="socialNetworkButton"></img>
    );
  }
}

/**
 * 
 * @param {*} props (Page)
 * @returns The html code for the current page depending on props.Page
 */
function CurrentPage(props) {
  let influenceurs = [
    'A','B','C','D','E','F','G','H','I'
  ];
    if (props.Page == 'Accueil')
    {
      return(
        <>
        <h1 className='title'>{props.Page}</h1>
        <div>
        <SearchBar products={influenceurs} />
      </div>
        </>
        /* The text area stands for the research bar */
      );
    }

    else if (props.Page == 'Réseaux') {
      return(
        <>
      <h1 className='title'>{props.Page}</h1>
      <SocialNetworkButton Image="Youtube_logo.png"/>
      </>
      );
    }

    else return(<h1 className='title'>{props.Page}</h1>);

  };  
  
/**
 * Create the SearchBar
 */
 function SearchBar(props) {
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
            return <li key={product} className='list-item'><a href='#'>{product}</a></li>
          })}
        </ul>
      </div>
    </div>
  );
}
/**
 * Describe the state of the page and places all the needed beacons
 */

class MainContainer extends React.Component {
  /**
   * Class constructor
   * @param {*} props 
   * Initialise the current Page to Acceuil
   */
constructor(props) {
  super(props);
  this.state = { curPage : 'Accueil'}
}
/**
 * 
 * @returns The html code for the whole page
 */
  render() {
    return (
      <div className='container' id='cont'>
        <aside className='NavBar'>
          <MenuLink Page="Accueil" onClick={() => this.setState({curPage :'Accueil'})}/>
          <MenuLink Page="Statistiques" onClick={() => this.setState({curPage :'Statistiques'})}/>
          <MenuLink Page="Réseaux" onClick={() => this.setState({curPage :'Réseaux'})}/>
          <MenuLink Page="A propos" onClick={() => this.setState({curPage :'A propos'})}/>
        </aside>
  
        <div className='pageContainer'>
          <CurrentPage Page={this.state.curPage} />
        </div>
      </div>
  
    );
  }

}


export default App;
