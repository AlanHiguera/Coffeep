
import { Routes, Route} from 'react-router-dom'
import LoginPage from './pages/Iniciosesion'
import CreateRecipePage from './pages/CrearReceta'
import Header from './componets/Lineasup'
import Footer from './componets/Lineasinf'

function App() {
  

  return (
    <>
      <div className="flex flex-col min-h-screen">
        <Header />
        <main className="flex-grow">
        <Routes> 
          <Route path="/iniciosesion" element={<LoginPage/>} />
          <Route path="/crearreceta" element={<CreateRecipePage/>} />
          <Route path="*" element={<h1>Not Found</h1>} />


        </Routes>
        </main>
        <Footer />
      </div>
    </>
  )
}

export default App
