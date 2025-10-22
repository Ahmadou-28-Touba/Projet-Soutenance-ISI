<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold">Tableau de Bord ISI</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="mr-4">Bonjour, {{ user.prenom }} {{ user.nom }}</span>
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
              {{ user.role }}
            </span>
                        <button @click="logout" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Déconnexion
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-6 px-4">
            <!-- Cartes statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total des absences</p>
                            <p class="text-2xl font-bold text-gray-900">{{ absences.length }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">En attente</p>
                            <p class="text-2xl font-bold text-gray-900">{{ absencesEnAttente.length }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Validées</p>
                            <p class="text-2xl font-bold text-gray-900">{{ absencesValidees.length }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des absences -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Mes absences</h2>
                    <button @click="loadAbsences" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Actualiser
                    </button>
                </div>

                <div v-if="loading" class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                    <p class="mt-2 text-gray-600">Chargement des absences...</p>
                </div>

                <div v-else-if="error" class="text-center py-8">
                    <p class="text-red-500 mb-4">{{ error }}</p>
                    <button @click="loadAbsences" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Réessayer
                    </button>
                </div>

                <div v-else>
                    <div v-if="absences.length === 0" class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-lg">Aucune absence déclarée</p>
                    </div>

                    <div v-else class="space-y-4">
                        <div v-for="absence in absences" :key="absence.id"
                             class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        Du {{ formatDate(absence.date_debut) }} au {{ formatDate(absence.date_fin) }}
                                    </h3>
                                    <p class="text-gray-600 mt-1">{{ absence.motif }}</p>
                                    <div class="flex items-center mt-3 space-x-4">
                    <span class="px-3 py-1 text-sm rounded-full font-medium"
                          :class="statusClass(absence.statut)">
                      {{ getStatusText(absence.statut) }}
                    </span>
                                        <span class="text-sm text-gray-500">
                      Créée le {{ formatDateTime(absence.created_at) }}
                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Dashboard',
    data() {
        return {
            user: {},
            absences: [],
            loading: true,
            error: ''
        }
    },
    computed: {
        absencesEnAttente() {
            return this.absences.filter(a => a.statut === 'en_attente');
        },
        absencesValidees() {
            return this.absences.filter(a => a.statut === 'validée');
        }
    },
    async mounted() {
        await this.loadUser();
        await this.loadAbsences();
    },
    methods: {
        async loadUser() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await axios.get('/api/user', {
                    headers: { Authorization: `Bearer ${token}` }
                });
                this.user = response.data;
            } catch (error) {
                this.handleAuthError(error);
            }
        },

        async loadAbsences() {
            this.loading = true;
            this.error = '';

            try {
                const token = localStorage.getItem('auth_token');
                const response = await axios.get('/api/absences', {
                    headers: { Authorization: `Bearer ${token}` }
                });
                this.absences = response.data;
            } catch (error) {
                this.error = 'Erreur lors du chargement des absences';
                this.handleAuthError(error);
            } finally {
                this.loading = false;
            }
        },

        handleAuthError(error) {
            if (error.response?.status === 401) {
                localStorage.removeItem('auth_token');
                this.$router.push('/');
            }
        },

        async logout() {
            try {
                const token = localStorage.getItem('auth_token');
                if (token) {
                    await axios.post('/api/logout', {}, {
                        headers: { Authorization: `Bearer ${token}` }
                    });
                }
            } catch (error) {
                console.error('Erreur logout:', error);
            } finally {
                localStorage.removeItem('auth_token');
                this.$router.push('/');
            }
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('fr-FR');
        },

        formatDateTime(date) {
            return new Date(date).toLocaleString('fr-FR');
        },

        getStatusText(statut) {
            const texts = {
                'en_attente': 'En attente',
                'validée': 'Validée',
                'rejetée': 'Rejetée'
            };
            return texts[statut] || statut;
        },

        statusClass(statut) {
            const classes = {
                'en_attente': 'bg-yellow-100 text-yellow-800',
                'validée': 'bg-green-100 text-green-800',
                'rejetée': 'bg-red-100 text-red-800'
            };
            return classes[statut] || 'bg-gray-100 text-gray-800';
        }
    }
}
</script>
