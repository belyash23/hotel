<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import 'vue-select/dist/vue-select.css';
import { computed } from 'vue';

const props = defineProps({
    users: {
        type: Array,
        default: () => ([]),
    },
});

const form = useForm({
    name: '',
    inn: '',
    address: '',
    director: null,
    owner: null,
});

const submit = () => {
    form.post(route('hotels.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Hotel Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hotel Create</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="inn" value="INN" />

                            <TextInput
                                id="inn"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.inn"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.inn" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="inn" value="Address" />

                            <TextInput
                                id="address"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.address"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="owner_id" value="Owner" />

                            <v-select
                                :options="users"
                                id="owner_id"
                                v-model="form.owner"
                            />

                            <InputError class="mt-2" :message="form.errors.owner_id" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="director_id" value="Director" />
                                <v-select
                                    :options="users"
                                    id="director_id"
                                    v-model="form.director"
                                />

                            <InputError class="mt-2" :message="form.errors.director_id" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Hotel
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
