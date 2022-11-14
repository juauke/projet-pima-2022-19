import React from "react";

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
 
export {MenuLink, MenuCross} 