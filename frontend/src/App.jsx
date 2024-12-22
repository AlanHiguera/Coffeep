import React from "react";

function App() {
  useEffect(() => {
    const [data, setData] = useState([])
    fetch('http://localhost:8081/users')
    .then(res => res.json())
    .then(data => setData(data))
    .catch(err => console.log(err));
  }, []);
  return (
    <div style={{padding: '50px'}}>
      <table>
        <thead>
          <th>ID</th>
          <th>NICKNAME</th>
          <th>PASSWORD</th>
        </thead>
        <tbody>
          {data.map((d, i)  => (
            <tr key={i}>
              <td>{d.id}</td>
              <td>{d.name}</td>
              <td>{d.password}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}

export default App;