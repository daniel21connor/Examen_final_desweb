<template>
    <div class="container mt-5 text-center">
        <h2 class="text-center mb-4 text-primary">Datos de la API de Picsum</h2>
        <!-- Mostrar error si lo hay -->
        <div v-if="error" class="alert alert-danger">{{ error }}</div>
        <!-- Mostrar spinner mientras se cargan los datos -->
        <div v-if="loading" class="d-flex justify-content-center align-items-center my-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Mostrar la lista de imágenes cuando se cargan los datos -->
        <div v-if="images.length > 0" class="image-grid">
            <div v-for="image in images" :key="image.id" class="image-item">
                <div class="card shadow-sm">
                    <img :src="image.download_url" alt="Imagen de Picsum" class="card-img-top image-preview">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ image.author }}</h5>
                        <p class="card-text">Download URL:</p>
                        <a :href="image.download_url" target="_blank" class="btn btn-outline-primary btn-sm w-100">Ver Imagen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            images: [],
            error: null,
            loading: false
        };
    },
    mounted() {
        this.fetchPicsumData();
    },
    methods: {
        fetchPicsumData() {
            this.loading = true;
            axios.get('/api/picsum-proxy')
                .then(response => {
                    if (response.data && Array.isArray(response.data)) {
                        this.images = response.data;
                    } else {
                        this.error = 'Los datos recibidos no son válidos.';
                        console.error('Datos recibidos:', response.data);
                    }
                })
                .catch(error => {
                    if (error.response) {
                        this.error = `Error ${error.response.status}: ${error.response.data.message || error.response.statusText}`;
                        console.error('Error con respuesta:', error.response);
                    } else if (error.request) {
                        this.error = 'No se recibió una respuesta del servidor de la API de Picsum.';
                        console.error('Error en la solicitud:', error.request);
                    } else {
                        this.error = `Error al cargar los datos: ${error.message}`;
                        console.error('Error:', error.message);
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
};
</script>

<style>
.spinner-border {
    display: block;
    margin: 20px auto;
}

.image-preview {
    height: 200px;
    object-fit: cover;
    border-radius: 0.25rem;
}

.container {
    max-width: 900px;
}

.card {
    text-align: center;
    height: 100%;
}

.image-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    padding: 0.5rem;
}

.image-item {
    width: 100%;
}

@media (max-width: 768px) {
    .image-grid {
        grid-template-columns: 1fr;
    }
}
</style>
