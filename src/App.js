
import './App.css';
import './SideBar.css';
import './SearchBar.css';
import './SocialNetwork.css';
import React, { useState } from "react";
import {SocialNetworkPage, YoutuberInfo}  from "./SocialNetworkMenu.js";
import {MenuCross, MenuLink} from "./SideMenu.js";  
import SearchBar from "./SearchBar.js";  
import LogButton from "./UserConnexion.js";

/* Function exported to render the page */

function App() {
  
  return (
        <MainContainer/>
  );
}


/**
 * 
 * @param {*} props (Page)
 * @returns The html code for the current page depending on props.Page
 */

class CurrentPage extends React.Component {

constructor(props) {
  super(props);
  this.state = {jdg : false}
}

 render() {
  let influenceurs = [
    "Hubert Bonnisseur de la Bath",'Noël Flantier','Lucien Bramard','Larmina','Jack','Dolorès Koulechov','Heinrich','Sliman','Armand',"Joueur Du Grenier"
  ];
    if (this.props.Page == 'Accueil')
    {
      return(
        <>
        <div>
        <SearchBar products={influenceurs} onClick={() => {this.setState({jdg : true})}}/>
        <div className={this.state.jdg ? 'resultSearch' : 'hide'}>
        <YoutuberInfo Name="Joueur Du Grenier" Image="JDG_pic.jpg" Follower="3,72 M" NombreVideos="150" NombreVues="1 025 230 900 vues" Link="https://www.youtube.com/user/joueurdugrenier" />
        </div>
      </div>
        </>
      );
    }

    else if (this.props.Page == 'Réseaux') {
      return(
        <>
      <SocialNetworkPage/>
      </>
      );
    }

    else return(<></>);

  };  

}



  function TopBar(props) {
    return<>
    <div className='topBar'>
    
    <MenuCross onClick={props.onClick}/>
     <h1 className='title'>{props.Page}</h1>
    <LogButton Page="Log in" Link="../PHP/Gestion_Compte/login.php"/>
     <h1 className='shriimpeTitle'><em> Shriimpe </em></h1>
     </div>
     </>
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
