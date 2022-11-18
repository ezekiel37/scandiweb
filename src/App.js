import './App.scss';
import { Home, AddProducts } from './pages';
import {
  // BrowserRouter,
  Routes,
  Route,
  Navigate,
  useNavigate,
} from "react-router-dom";

function App() {
  return (
    <div className="App">
       <Routes>
       <Route index path="/" element={<Home/>} />
        <Route index path="/addproduct" element={<AddProducts />} />
       </Routes>
     
    </div>
  );
}

export default App;
