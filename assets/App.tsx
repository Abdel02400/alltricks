import { useState, useEffect } from 'react'
import Card from './components/Card'
import CardSkeleton from './components/skeleton/CardSkeleton'

import './dependencies/css/app.scss'

function App() {
  const [onLoadArticle, setOnLoadArticle] = useState<boolean>(false)
  const [articles, setArticles] = useState()

  const loadArticle = async () => {
    let requestOptions = {method: 'GET'}
    let response = await fetch('http://localhost:8000/api/articles')

    if (response.status === 200) {
      let articles = await response.json()
      setArticles(articles)
    }
  }
  
  const renderCardSkeleton = () => {

    let cardSkeleton = []

    for (let i = 0; i < 6; i++) {
      cardSkeleton.push(<CardSkeleton key={i}/>)
    }

    return cardSkeleton
  }

  useEffect(() => {
    loadArticle()
  }, [])

  return (
    <div className="articles container">
      {onLoadArticle ? renderCardSkeleton() : 
      (
        <Card />
      )}
    </div>
  )
}

export default App
