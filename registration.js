document.getElementById('otherCountry').addEventListener('change', function() {
    document.getElementById('otherCountryForm').style.display = this.checked ? 'block' : 'none';
    document.getElementById('philippinesForm').style.display = this.checked ? 'none' : 'block';
});

document.getElementById('philippines').addEventListener('change', function() {
    document.getElementById('philippinesForm').style.display = this.checked ? 'block' : 'none';
    document.getElementById('otherCountryForm').style.display = this.checked ? 'none' : 'block';
});

var config = {
    cUrl: 'https://api.countrystatecity.in/v1/countries',
    ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
}

const countrySelect = document.querySelector('.country');
const stateSelect = document.querySelector('.state');
const citySelect = document.querySelector('.city');

function loadCountries() {
    const apiEndPoint = config.cUrl;

    fetch(apiEndPoint, {
            headers: {
                "X-CSCAPI-KEY": config.ckey
            }
        })
        .then(response => response.json())
        .then(data => {
            // Clear existing options
            countrySelect.innerHTML = '<option value="">Select Country</option>';

            // Populate countries
            data.forEach(country => {
                const option = new Option(country.name, country.iso2);
                countrySelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading countries:', error))
        .finally(() => {
            // Reset state and city selects
            stateSelect.innerHTML = '<option value="">Select State</option>';
            citySelect.innerHTML = '<option value="">Select City</option>';
        });
}

function loadStates() {
    const selectedCountryCode = countrySelect.value;

    // Clear city options
    citySelect.innerHTML = '<option value="">Select City</option>';


    fetch(`${config.cUrl}/${selectedCountryCode}/states`, {
            headers: {
                "X-CSCAPI-KEY": config.ckey
            }
        })
        .then(response => response.json())
        .then(data => {
            // Populate states
            data.forEach(state => {
                const option = new Option(state.name, state.iso2);
                stateSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading states:', error));
}

function loadCities() {
    const selectedCountryCode = countrySelect.value;
    const selectedStateCode = stateSelect.value;

    // Clear city options
    citySelect.innerHTML = '<option value="">Select City</option>';

    fetch(`${config.cUrl}/${selectedCountryCode}/states/${selectedStateCode}/cities`, {
            headers: {
                "X-CSCAPI-KEY": config.ckey
            }
        })
        .then(response => response.json())
        .then(data => {
            // Populate cities
            data.forEach(city => {
                const option = new Option(city.name, city.iso2);
                citySelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading cities:', error));
    
    // Set the selected city value to the corresponding input field
    document.getElementById('city').value = citySelect.value;
}

// Event listeners
countrySelect.addEventListener('change', loadStates);
stateSelect.addEventListener('change', loadCities);

// Initialize
window.onload = loadCountries;

var my_handlers = {
    fill_provinces:  function(){
        var region_code = $( "option:selected" , this).data('psgc-code');
        $('#province').ph_locations('fetch_list', [
            { 
                "filter": {
                    "region_code": region_code
                }
            }
        ]);                    
        
    },

    fill_cities: function(){
        var province_code = $( "option:selected" , this).data('psgc-code');
        $('#cityMunicipality').ph_locations('fetch_list', [
            { 
                "filter": {
                    "province_code": province_code
                }
            }
        ]);
    },

    fill_barangays: function(){
        var city_code = $( "option:selected" , this).data('psgc-code');
        var province_code = $( "#province option:selected").data('psgc-code');
        $('#barangay').ph_locations('fetch_list', [
            { 
                "filter": {
                    "province_code": province_code,
                    "city_code": city_code
                }
            }
        ]);
    }
};

$(function(){
    $('#region').on('change', my_handlers.fill_provinces);
    $('#province').on('change', my_handlers.fill_cities);
    $('#cityMunicipality').on('change', my_handlers.fill_barangays);

    $('#region').ph_locations({'location_type': 'regions'});
    $('#province').ph_locations({'location_type': 'provinces'});
    $('#cityMunicipality').ph_locations({'location_type': 'cities'});
    $('#barangay').ph_locations({'location_type': 'barangays'});

    $('#region').ph_locations('fetch_list', [{'location_type': 'regions', "selected_value" : "REGION I (ILOCOS REGION)"}]);
});