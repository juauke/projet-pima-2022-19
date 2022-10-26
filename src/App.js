
import './App.css';
import React, { useState } from "react";


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


class MenuCross extends React.Component {
  state = { isActive: false };
  handleToggle = () => {
    this.setState({ isActive: !this.state.isActive });  };

    render() {
      const isActive = this.state.isActive;
      return(
        <> 
        <div className='crossContainer'>
      
        <svg
              className={isActive ? "active" : null}
              width="50"
              height="50"
              viewBox="0 0 32 42"
              xmlns="http://www.w3.org/2000/svg"
              onClick={() => {this.props.onClick(); this.handleToggle()}} /*this.handleToggle() */
            >
              <g transform="matrix(1,0,0,1,-438.286,-264.004)">
                <g id="arrow_left1">  
                  <g
                    transform="matrix(-1,-1.22465e-16,1.22465e-16,-1,858.787,564.935)"
                  >
                    <path
                      id="top"
                      d="M390,270L420,270L420,270C420,270 420.195,250.19 405,265C389.805,279.81 390,279.967 390,279.967"
                    />
                  </g>
                  <g transform="matrix(-1,-2.44929e-16,-2.44929e-16,1,858.786,5)">
                    <path
                      id="bottom"
                      d="M390,270L420,270L420,270C420,270 420.195,250.19 405,265C389.805,279.81 390,279.967 390,279.967"
                    />
                  </g>
                  <g
                    transform="matrix(-1,-1.22465e-16,1.22465e-16,-1,858.787,569.935)"
                  >
                    <path id="middle" d="M390,284.967L420,284.967" />
                  </g>
                </g>
              </g>
            </svg>
        </div>
        </>)

    }
}


class SocialNetworkMenu extends React.Component {
  constructor(props) {
    super(props);
    this.state = {currNetwork : 'Youtube'}
  }

  handleToggleButton(newNetwork) {
    this.setState({currNetwork : newNetwork});
  }

  render() {
    return(
    <>
      <div className='socialNetworkMenu'>
        <SocialNetworkButton Image="Youtube_logo.png" onClick={() => {this.props.onClick1(); this.handleToggleButton('Youtube');}} Active={this.state.currNetwork == 'Youtube'}/>
        <SocialNetworkButton Image="Twitch_logo.png" onClick={() => {this.props.onClick2(); this.handleToggleButton('Twitch');}} Active={this.state.currNetwork == 'Twitch'}/>
        <SocialNetworkButton Image="Facebook_logo.png" onClick={() => {this.props.onClick3(); this.handleToggleButton('Facebook');}} Active={this.state.currNetwork == 'Facebook'}/>
        <SocialNetworkButton Image="Instagram_logo.png" onClick={() => {this.props.onClick4(); this.handleToggleButton('Instagram');}} Active={this.state.currNetwork == 'Instagram'}/>
        <SocialNetworkButton Image="Youtube_logo.png"/>
        <SocialNetworkButton Image="Youtube_logo.png"/>
        <SocialNetworkButton Image="Youtube_logo.png"/>
        <SocialNetworkButton Image="Youtube_logo.png"/>
        <SocialNetworkButton Image="Youtube_logo.png"/>
        <SocialNetworkButton Image="Youtube_logo.png"/>
      </div>
    </>
    );
  }

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
      <img src={this.props.Image} className={this.props.Active ? " activeButton" : "socialNetworkButton "} onClick={this.props.onClick}></img>
    );
  }
}

class SocialNetworkContent extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    if(this.props.Network == 'Youtube')
    {
    return(<>
    <YoutubeNetworkContent/>
    
    </>);
    }

    else {
      return(<>
    <h1 className='networkTitle'>{this.props.Network}</h1>
      
      </>); 
    }
  }

}

class YoutubeNetworkContent extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    return(
    <>
      <h1 className='youtubeTitle'>Youtube</h1>
    </>);
  }

}


class SocialNetworkPage extends React.Component {
  constructor(props) {
    super(props);
    this.state = { network : 'Youtube'}
  }

setNetwork(newNetwork)
{
  this.setState({network : newNetwork})
}

  render() {
    return(<>
    <SocialNetworkMenu 
    onClick1={() => this.setNetwork('Youtube')} 
    onClick2={() => this.setNetwork( 'Twitch')}
    onClick3={() => this.setNetwork('Facebook')}
    onClick4={() => this.setNetwork('Instagram')}
    />
    <SocialNetworkContent Network={this.state.network}/>
    </>)
  }
}


/**
 * 
 * @param {*} props (Page)
 * @returns The html code for the current page depending on props.Page
 */
function CurrentPage(props) {
  let influenceurs = [
    "Hubert Bonnisseur de la Bath",'Noël Flantier','Lucien Bramard','Larmina','Jack','Dolorès Koulechov','Heinrich','Sliman','Armand'
  ];
    if (props.Page == 'Accueil')
    {
      return(
        <>
        <div>
        <SearchBar products={influenceurs} />
      </div>
        </>
      );
    }

    else if (props.Page == 'Réseaux') {
      return(
        <>
      <SocialNetworkPage/>
      </>
      );
    }

    else return(<></>);

  };  

  function TopBar(props) {
    return<>
    <div className='topBar'>
    
    <MenuCross onClick={props.onClick}/>
     <h1 className='title'>{props.Page}</h1>
     <h1 className='shriimpTitle'><em> Shriimp </em></h1>
     </div>
     </>
  }
  
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
  this.state = { curPage : 'Accueil' ,navBar : true}
}

handleToggleNav = () => {
  this.setState({ navBar: !this.state.navBar });};
/**
 * 
 * @returns The html code for the whole page
 */
  render() {  
    const navBar = this.state.navBar;
    return (
      <div className='container' id='cont'>
        <aside className={navBar ? 'NavBar ' : "navBarHidden"} id='NavBar'>
          <div className='linksContainer'>
          <MenuLink Page="Accueil" onClick={() => this.setState({curPage :'Accueil'})}/>
          <MenuLink Page="Statistiques" onClick={() => this.setState({curPage :'Statistiques'})}/>
          <MenuLink Page="Réseaux" onClick={() => this.setState({curPage :'Réseaux'})}/>
          <MenuLink Page="A propos" onClick={() => this.setState({curPage :'A propos'})}/>
          </div>
        </aside>
  
        <div className='pageContainer'>
          <TopBar Page={this.state.curPage} onClick={this.handleToggleNav} />
          <div className='currentPage'>
          <CurrentPage Page={this.state.curPage} />
          </div>
        </div>
      </div>
  
    );
  }

}


export default App;
