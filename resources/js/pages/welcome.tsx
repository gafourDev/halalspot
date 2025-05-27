import React, { useState, useEffect, useCallback } from 'react';
import axios from 'axios';

function HomePage() {
  const [restaurants, setRestaurants] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [location, setLocation] = useState<{ lat: number; lng: number } | null>(null);
  const [useLocation, setUseLocation] = useState(true);
  const [searchQuery, setSearchQuery] = useState('');

  const fetchRestaurants = useCallback(async (lat?: number, lng?: number, query?: string) => {
    setLoading(true);
    setError('');
    try {
      let url = '/api/restaurants';
      const params: Record<string, any> = {};
      if (lat && lng) {
        url += '/nearby';
        params.latitude = lat;
        params.longitude = lng;
      }
      if (query) {
        params.search = query;
      }
      const response = await axios.get(url, { params });
      setRestaurants(response.data);
    } catch (err) {
      setError('Failed to fetch restaurants.');
      setRestaurants([]);
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    if (useLocation && navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const coords = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          setLocation(coords);
          fetchRestaurants(coords.lat, coords.lng, searchQuery);
        },
        (err) => {
          setError('Location access denied.');
          setLocation(null);
          fetchRestaurants(undefined, undefined, searchQuery);
        }
      );
    } else {
      setLocation(null);
      fetchRestaurants(undefined, undefined, searchQuery);
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [useLocation, fetchRestaurants]);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    if (useLocation && location) {
      fetchRestaurants(location.lat, location.lng, searchQuery);
    } else {
      fetchRestaurants(undefined, undefined, searchQuery);
    }
  };

  const handleLocationToggle = () => {
    setUseLocation((prev) => !prev);
  };

  return (
    <div className="home-page">
      <header className="app-header">
        <h1>HalalSpot</h1>
        <p className="tagline">Find <strong>halal restaurants near you</strong></p>
      </header>

      <div className="search-section">
        <div className="location-option">
          <input
            type="checkbox"
            id="currentLocation"
            checked={useLocation}
            onChange={handleLocationToggle}
          />
          <label htmlFor="currentLocation">Use Current Location</label>
        </div>

        <form onSubmit={handleSearch} className="search-box">
          <input
            type="text"
            placeholder="Search for a restaurant..."
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
          />
          <button type="submit">Search</button>
        </form>
      </div>

      <div className="divider"></div>

      {loading ? (
        <p>Loading restaurants...</p>
      ) : error ? (
        <p className="error">{error}</p>
      ) : restaurants.length === 0 ? (
        <p>No halal restaurants found.</p>
      ) : (
        <>
          <h2 className="results-count">{restaurants.length} halal places found</h2>
          <div className="divider"></div>
          <div className="restaurants-list">
            {restaurants.map((restaurant: any) => (
              <div key={restaurant.id} className="restaurant-card">
                <h3>{restaurant.name}</h3>
                <p className="address">{restaurant.address}</p>
                <div className="details">
                  <span className="cuisine">[{restaurant.cuisine_type}]</span>
                  <span className="status">Open Now</span>
                </div>
              </div>
            ))}
          </div>
        </>
      )}
    </div>
  );
}

export default HomePage;