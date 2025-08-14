# Recycling Facility Management App

## Overview
This Laravel application allows managing facilities with the following features:

- Create, edit, view, and delete facilities
- Each facility has a business name, last update date, street address, and accepted materials
- Materials are stored in a separate table and linked via a many-to-many relationship
- Search, filter, and sort facilities
- Export filtered results to CSV
- Google Maps integration for facility addresses (optional)

---

## Database Design & Relationships

**Tables:**

- `facilities`
  - `id`, `business_name`, `last_update_date`, `street_address`, `timestamps`
- `materials`
  - `id`, `name`, `timestamps`
- `facility_material` (pivot table)
  - `facility_id`, `material_id`

**Relationships:**

- Facility ↔ Materials: Many-to-Many
- 

**Features Implementation**
1. Search

    Implemented via a query scope on Facility model

    Filters facilities by business_name using LIKE %search%

2. Filter by Material

    Dropdown on index page

    Filters facilities that have the selected material

    Implemented using whereHas on materials relationship

3. Sort

    Optional query parameter to sort by last_update_date

    Default: descending

4. Export

    Exports currently filtered facilities to CSV

    Includes columns: Business Name, Last Update, Address, Materials Accepted
