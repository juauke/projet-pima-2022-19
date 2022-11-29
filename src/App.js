
import './App.css';
import './SideBar.css';
import './SearchBar.css';
import './SocialNetwork.css';
import './Fav.css';
import React, { useState } from "react";
import {SocialNetworkPage, YoutuberInfo}  from "./SocialNetworkMenu.js";
import {MenuCross, MenuLink} from "./SideMenu.js";  
import SearchBar from "./SearchBar.js";  
import LogButton from "./UserConnexion.js";
import {influenceurs} from "./SearchBar.js";
import Jquery from "jquery"
import FavPage from "./Fav.js";

/* Function exported to render the page */

function App() {
  
  return (
        <MainContainer/>
  );
}

function StatImg(props){
  return <img src={props.Image} class="statImg"></img>;
}

/**
 * 
 * @param {*} props (Page)
 * @returns The html code for the current page depending on props.Page
 */

class CurrentPage extends React.Component {

constructor(props) {
  super(props);
  this.state = {influenceur : [],jdg:false }
}
rerender = () => {
  this.forceUpdate();
};
forceUpdate = () => {
  this.setState((state) => ({
    influenceur :influenceurs
  }));
};

 render() {
  //let influenceurs = [
  //  "Hubert Bonnisseur de la Bath",'Noël Flantier','Lucien Bramard','Larmina','Jack','Dolorès Koulechov','Heinrich','Sliman','Armand',"Joueur Du Grenier"
  //];
    //let influenceurs=[["Test","Test","Test","Test","Test","Test"],["Test2","Test2","Test2","Test2","Test2","Test2"]]
    const is_undefined=influenceurs!==undefined;
    let e=document.querySelector("#results");
    const nulel= e!=null;
    const not_empty=influenceurs.length!==0;

    var session;
    Jquery.ajaxSetup({cache: false})
    Jquery.ajax({
      url: 'PHP/getsession.php',
      success: function (data) {
        session = data;
      },
      async: false
    });
    var sessionObj = JSON.parse(session);
 

    if (this.props.Page == 'Accueil')
    {
      
      return(
        <>
        <div>
        {console.log(influenceurs)};
        <SearchBar products={influenceurs} rerender={this.rerender} onChange={() => {alert(1)}} />
        <div id="results">
        {/*(()=> {
          if(nulel){
            e.innerHTML=""
          }
        })()*/}
        {is_undefined && not_empty &&
        influenceurs.map(i=>
          <YoutuberInfo Name={i[0]} Image={i[4]}  Follower={i[2]}  NombreVideos={i[3]}  NombreVues={i[1]} Link={i[5]} />)}
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

    else if (this.props.Page == 'Favoris') {
      if (!sessionObj.loggedin){
        return(<>
        <p className='favPlacehold'>Pour accéder à vos favoris veuillez vous <a href="../PHP/Gestion_Compte/login.php">connecter</a> ou <a href="../PHP/Gestion_Compte/register.php">créer un compte.</a></p>
        </>)

      }
      else
      return(
        <>
        <FavPage/>
        </>
      )
    }

    else if (this.props.Page == 'Statistiques') {
      return(<>
      <StatImg Image="./images/abos_jdg.png"/>
      <StatImg Image="./images/hist.png"/>
      </>);
    }


    else return(<></>);

  };  

}




  function TopBar(props) {
    var session;
    Jquery.ajaxSetup({cache: false})
    Jquery.ajax({
      url: 'PHP/getsession.php',
      success: function (data) {
        session = data;
      },
      async: false
    });
    var sessionObj = JSON.parse(session);
 


    if(sessionObj.loggedin)
    {return <>
      <div className='topBar'>
    
      <MenuCross onClick={props.onClick}/>
       <h1 className='title'>{props.Page}</h1>
       <h4 id="username"> {sessionObj.username} </h4>
      <LogButton Page="Se déconnecter" Link="../PHP/Gestion_Compte/logout.php"/>
      <LogButton Page="Changer mon mot de passe" Link="../PHP/Gestion_Compte/change-password.php"/>
       <h1 className='shriimpeTitle'><em>Shriimpe </em></h1>
       </div>
       </>

    }
    else{
    return<>
    <div className='topBar'>
    
    <MenuCross onClick={props.onClick}/>
     <h1 className='title'>{props.Page}</h1>
    <LogButton Page="Se connecter" Link="../PHP/Gestion_Compte/login.php"/>
    <LogButton Page="S'inscrire" Link="../PHP/Gestion_Compte/register.php"/>
     <h1 className='shriimpeTitle'><em>Shriimpe </em></h1>
     </div> 
     </>
    }
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
          <MenuLink Page="Favoris" onClick={() => this.setState({curPage :'Favoris'})}/>
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
