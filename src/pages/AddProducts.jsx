import React, { useState} from "react";
import axios from "axios";
import { Link, useNavigate } from "react-router-dom";
import {baseUrl} from "../utilities/Api.jsx";

const AddProducts = () => {
  const [productType, setProductType] = useState("Dvd");
  const [sku, setSku] = useState("");
  const [name, setName] = useState("");
  const [price, setPrice] = useState("");
  const [size, setSize] = useState("");
  const [height, setHeight] = useState("");
  const [width, setWidth] = useState("");
  const [length, setLength] = useState("");
  const [weight, setWeight] = useState("");
  const [check, setCheck] = useState(false);
  const [error, setError] = useState(false);

  const navigate = useNavigate();

  const handleChange = (e) => {
    setProductType(e.target.value);
    setSize("");
    setWeight("");
    setWidth("");
    setHeight("");
    setLength("");
  };

  const handleSkuChange = (e) => {
    setSku(e.target.value);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    axios
      .post(baseUrl+"/check", { sku: sku })
      .then((res) => {
        if (res.data) {
          setCheck(true);
        } else {
          setCheck(false);
          submit();
        }
      })
      .catch((error) => {});
  };

 //product types 

  const type = {
    Dvd: { size },
    Book: { weight },
    Furniture: { width, height, length },
  };

  const submit = () => {
    let flag = "";
    if (sku === "" || name === "" || price === "") {
      setError(true);
      flag = "failed";
    }

    Object.keys(type).forEach((key) => {
      Object.values(type[key]).forEach((item) => {
        if (productType === key && item === "") {
          console.log("error");
          setError(true);
          flag = "failed";
        }
      });
    });

    if (flag !== "failed") {
      axios
        .post(baseUrl, {
          sku: sku,
          name: name,
          price: price,
          size: size,
          select: productType,
          height: height,
          width: width,
          length: length,
          weight: weight,
        })
        .then((res) => {
          navigate("/");
        });
    } else {
    }
  };

  return (
    <>
      <form onSubmit={handleSubmit} id="product_form">
        <div className="formcontainer">
          {/* button */}
          <div className="header">
            <div>
              <h3>Product Add</h3>
            </div>
            <div>
              <button className="savebtn" id="submitbtn" type="submit">
                Save
              </button>
              <Link to="/" className="cancelbtn" id="cancel" type="button">
                Cancel
              </Link>
            </div>
          </div>
          <div className="line"></div>

          <div>
            <label>Sku</label>
            <input
              id="sku"
              type="text"
              name="sku"
              onChange={handleSkuChange}
              value={sku}
            />
            {check ? (
              <small id="skuValid">Sku already exists. Enter a new one</small>
            ) : (
              <small></small>
            )}
            {sku === "" && error ? (
              <small>Sku cannot be blank</small>
            ) : (
              <small></small>
            )}
          </div>

          <div>
            <label>Name</label>
            <input
              id="name"
              type="text"
              name="name"
              onChange={(e) => setName(e.target.value)}
              value={name}
            />
            {name === "" && error ? (
              <small id="nameValid">Name cannot be blank</small>
            ) : (
              <small></small>
            )}
          </div>

          <div>
            <label>Price($)</label>
            <input
              id="price"
              type="text"
              name="price"
              onChange={(e) => setPrice(e.target.value)}
              value={price}
            />
            {price === "" && error ? (
              <small id="nameValid">Price cannot be blank</small>
            ) : (
              <small></small>
            )}
          </div>

          <div className="switcher">
            <label>Type Switcher</label>
            <select
              onChange={handleChange}
              id="productType"
              name={productType}
              value={productType}
            >
              <option name="Dvd" value="Dvd" id="Dvd">
                DVD
              </option>
              <option name="Furniture" value="Furniture" id="Furniture">
                Furniture
              </option>
              <option name="Book" value="Book" id="Book">
                Book
              </option>
            </select>
          </div>
        
          {/* Product Categories */}

          <div className="product">
            {productType === "Dvd" && (
              <div className="Dvd">
                <label>Size (Mb)</label>
                <input
                  id="size"
                  type="text"
                  name="size"
                  onChange={(e) => setSize(e.target.value)}
                  value={size}
                />
                {size === "" && error ? (
                  <small id="nameValid">Size cannot be blank</small>
                ) : (
                  <small></small>
                )}
                <p> Please, provide size in mb </p>
              </div>
            )}

            {productType === "Furniture" && (
              <div className="Furniture">
                <label>Height (CM)</label>
                <input
                  id="height"
                  type="text"
                  name="height"
                  onChange={(e) => setHeight(e.target.value)}
                  value={height}
                />
                <br></br>
                {height === "" && error ? (
                  <small id="nameValid">Height cannot be blank</small>
                ) : (
                  <small></small>
                )}

                <label>Width (CM)</label>
                <input
                  id="width"
                  type="text"
                  name="width"
                  onChange={(e) => setWidth(e.target.value)}
                  value={width}
                />
                <br></br>
                {width === "" && error ? (
                  <small id="nameValid">Width cannot be blank</small>
                ) : (
                  <small></small>
                )}
                <label>Length (CM)</label>
                <input
                  id="length"
                  type="text"
                  name="length"
                  onChange={(e) => setLength(e.target.value)}
                  value={length}
                />
                <br></br>
                {length === "" && error ? (
                  <small id="nameValid">Length cannot be blank</small>
                ) : (
                  <small></small>
                )}
                <p>Please, provide dimensions (HxWxL) in CM </p>
              </div>
            )}
            
            {productType === "Book" && (
              <div className="Book">
                <label>Weight (Kg)</label>
                <input
                  id="weight"
                  type="text"
                  name="weight"
                  onChange={(e) => setWeight(e.target.value)}
                  value={weight}
                />
                {weight === "" && error ? (
                  <small id="nameValid">Weight cannot be blank</small>
                ) : (
                  <small></small>
                )}
                <p>Please, provide weight in kg</p>
              </div>
            )}
          </div>
        </div>
      </form>
    </>
  );
};

export default AddProducts;
