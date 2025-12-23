<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Fleet Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Car Fleet Management</h1>
            <button class="btn btn-primary" id="addCarBtn">
                <i class="bi bi-plus-circle"></i> Add New Car
            </button>
        </div>

        <div id="alertContainer"></div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover" id="carsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Make & Model</th>
                            <th>Year</th>
                            <th>License Plate</th>
                            <th>Daily Rate</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="carsTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="carModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carModalTitle">Add New Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="carForm">
                        <input type="hidden" id="carId">
                        <input type="hidden" id="providerId" value="1">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="make" class="form-label">Make *</label>
                                <input type="text" class="form-control" id="make" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">Model *</label>
                                <input type="text" class="form-control" id="model" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="year" class="form-label">Year *</label>
                                <input type="number" class="form-control" id="year" min="1900" max="2026" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label">Color *</label>
                                <input type="text" class="form-control" id="color" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="licensePlate" class="form-label">License Plate *</label>
                                <input type="text" class="form-control" id="licensePlate" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dailyRate" class="form-label">Daily Rate (€) *</label>
                                <input type="number" class="form-control" id="dailyRate" step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="transmission" class="form-label">Transmission *</label>
                                <select class="form-select" id="transmission" required>
                                    <option value="">Select...</option>
                                    <option value="automatic">Automatic</option>
                                    <option value="manual">Manual</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fuelType" class="form-label">Fuel Type *</label>
                                <select class="form-select" id="fuelType" required>
                                    <option value="">Select...</option>
                                    <option value="petrol">Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="electric">Electric</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="seats" class="form-label">Seats *</label>
                                <input type="number" class="form-control" id="seats" min="1" max="20" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="doors" class="form-label">Doors *</label>
                                <input type="number" class="form-control" id="doors" min="2" max="6" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="countryId" class="form-label">Country</label>
                                <select class="form-select" id="countryId">
                                    <option value="">Select Country...</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cityId" class="form-label">City</label>
                                <select class="form-select" id="cityId">
                                    <option value="">Select City...</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select" id="status" required>
                                <option value="available">Available</option>
                                <option value="rented">Rented</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCarBtn">Save Car</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const API_BASE = '/api';
        let carModal;
        let allCities = [];

        $(document).ready(function() {
            carModal = new bootstrap.Modal(document.getElementById('carModal'));
            
            loadCars();
            loadCountries();
            loadCities();

            $('#addCarBtn').click(function() {
                resetForm();
                $('#carModalTitle').text('Add New Car');
                carModal.show();
            });

            $('#saveCarBtn').click(function() {
                saveCar();
            });

            $('#countryId').change(function() {
                filterCitiesByCountry($(this).val());
            });
        });

        function loadCars() {
            $.get(`${API_BASE}/cars`, function(cars) {
                displayCars(cars);
            }).fail(function(error) {
                showAlert('Error loading cars', 'danger');
            });
        }

        function loadCountries() {
            $.get(`${API_BASE}/countries`, function(countries) {
                let options = '<option value="">Select Country...</option>';
                countries.forEach(country => {
                    options += `<option value="${country.id}">${country.name}</option>`;
                });
                $('#countryId').html(options);
            });
        }

        function loadCities() {
            $.get(`${API_BASE}/cities`, function(cities) {
                allCities = cities;
                populateCityDropdown(cities);
            });
        }

        function populateCityDropdown(cities) {
            let options = '<option value="">Select City...</option>';
            cities.forEach(city => {
                options += `<option value="${city.id}" data-country="${city.country_id}">${city.name}</option>`;
            });
            $('#cityId').html(options);
        }

        function filterCitiesByCountry(countryId) {
            if (!countryId) {
                populateCityDropdown(allCities);
                return;
            }

            const filteredCities = allCities.filter(city => city.country_id == countryId);
            populateCityDropdown(filteredCities);
        }

        function displayCars(cars) {
            let rows = '';
            cars.forEach(car => {
                const location = car.country ? car.country.name : 'N/A';
                const statusBadge = getStatusBadge(car.status);
                
                rows += `
                    <tr>
                        <td>${car.id}</td>
                        <td><strong>${car.make} ${car.model}</strong></td>
                        <td>${car.year}</td>
                        <td>${car.license_plate}</td>
                        <td>$${parseFloat(car.daily_rate).toFixed(2)}</td>
                        <td>${location}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editCar(${car.id})">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteCar(${car.id})">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#carsTableBody').html(rows || '<tr><td colspan="8" class="text-center">No cars found</td></tr>');
        }

        function getStatusBadge(status) {
            const badges = {
                'available': '<span class="badge bg-success">Available</span>',
                'rented': '<span class="badge bg-primary">Rented</span>',
                'maintenance': '<span class="badge bg-warning">Maintenance</span>',
                'inactive': '<span class="badge bg-secondary">Inactive</span>'
            };
            return badges[status] || status;
        }

        function editCar(id) {
            $.get(`${API_BASE}/cars/${id}`, function(car) {
                $('#carId').val(car.id);
                $('#make').val(car.make);
                $('#model').val(car.model);
                $('#year').val(car.year);
                $('#color').val(car.color);
                $('#licensePlate').val(car.license_plate);
                $('#dailyRate').val(car.daily_rate);
                $('#transmission').val(car.transmission);
                $('#fuelType').val(car.fuel_type);
                $('#seats').val(car.seats);
                $('#doors').val(car.doors);
                $('#countryId').val(car.country_id || '');
                $('#status').val(car.status);
                
                if (car.country_id) {
                    filterCitiesByCountry(car.country_id);
                    setTimeout(() => {
                        $('#cityId').val(car.city_id || '');
                    }, 100);
                } else {
                    $('#cityId').val(car.city_id || '');
                }

                $('#carModalTitle').text('Edit Car');
                carModal.show();
            }).fail(function(error) {
                showAlert('Error loading car details', 'danger');
            });
        }

        function saveCar() {
            if (!$('#carForm')[0].checkValidity()) {
                $('#carForm')[0].reportValidity();
                return;
            }

            const carData = {
                provider_id: $('#providerId').val(),
                make: $('#make').val(),
                model: $('#model').val(),
                year: $('#year').val(),
                color: $('#color').val(),
                license_plate: $('#licensePlate').val(),
                daily_rate: $('#dailyRate').val(),
                transmission: $('#transmission').val(),
                fuel_type: $('#fuelType').val(),
                seats: $('#seats').val(),
                doors: $('#doors').val(),
                country_id: $('#countryId').val() || null,
                city_id: $('#cityId').val() || null,
                status: $('#status').val()
            };

            const carId = $('#carId').val();
            const method = carId ? 'PUT' : 'POST';
            const url = carId ? `${API_BASE}/cars/${carId}` : `${API_BASE}/cars`;

            $.ajax({
                url: url,
                type: method,
                contentType: 'application/json',
                data: JSON.stringify(carData),
                success: function(response) {
                    carModal.hide();
                    loadCars();
                    showAlert(`Car ${carId ? 'updated' : 'added'} successfully!`, 'success');
                },
                error: function(error) {
                    const message = error.responseJSON?.message || 'Error saving car';
                    showAlert(message, 'danger');
                }
            });
        }

        function deleteCar(id) {
            if (!confirm('Are you sure you want to delete this car?')) {
                return;
            }

            $.ajax({
                url: `${API_BASE}/cars/${id}`,
                type: 'DELETE',
                success: function(response) {
                    loadCars();
                    showAlert('Car deleted successfully!', 'success');
                },
                error: function(error) {
                    showAlert('Error deleting car', 'danger');
                }
            });
        }

        function resetForm() {
            $('#carForm')[0].reset();
            $('#carId').val('');
            populateCityDropdown(allCities);
        }

        function showAlert(message, type) {
            const alert = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            $('#alertContainer').html(alert);
            
            setTimeout(() => {
                $('.alert').alert('close');
            }, 3000);
        }
    </script>
</body>
</html>
