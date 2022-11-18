import React, { useState } from "react";
import { Link } from "react-router-dom";
import axios from "axios";
import {baseUrl} from "../utilities/Api.jsx";

const Home = () => {
  const [result, setResult] = useState([]);
  const [check, setCheck] = useState({
    products: [],
  
});
  const handleChange = (e) =>{
    // Destructuring
    const { value, checked } = e.target;
    const { products } = check;
      
    console.log(`${value} is ${checked}`);
     
    // Case 1 : The user checks the box
    if (checked) {
      setCheck({
        products: [...products, value]
        
      });
    }
  
    // Case 2  : The user unchecks the box
    else {
      setCheck({
        products: products.filter((e) => e !== value),
      
      });
    } 
  }
  const handleDelete = (e) => {
    e.preventDefault();
    axios.post(baseUrl+"/delete" , check)
    .then((data) => console.log(data))
    .catch((error) =>console.log(error))
  }

  axios
    .get(baseUrl)
    .then((data) => setResult(data.data))
    .catch((error) => console.log(error));

  return (
    <div>
      <form className="container">
        <div className="header">
          <div>
            <h3>Product List</h3>
          </div>
          <div>
            <Link
              style={{ textDecoration: "none" }}
              className="savebtn"
              to="/addproduct"
            >
              ADD
            </Link>
            <button onClick={handleDelete} className="deletebtn" id="delete-product-btn" type="submit">
              MASS DELETE
            </button>
          </div>
        </div>
        <div className="line"></div>
        <div className="boxcontainer">
          {result.map((item) => (
            <div className="box" key={item.id}>
              <input
                type="checkbox"
                value={item.id}
                name={item.id}
                onChange={handleChange}
                className="delete-checkbox"
              />
              <p>{item.sku}</p>
              <p>{item.name}</p>
              <p>{item.price}$</p>
              <p>{item.size != null && "Size:" + item.size + "mb"}</p>
              <p>{item.weight != null && "Weight:" + item.weight + "kg"}</p>
              <p>
                {item.height != null &&
                  item.width !=null &&
                  item.length !=null &&
                  "Dimensions:" +
                    item.height +
                    "x" +
                    item.width +
                    "x" +
                    item.length}
              </p>
            </div>
          ))}
        </div>
      </form>
    </div>
  );
};

export default Home;
