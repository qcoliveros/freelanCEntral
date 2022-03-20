<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-2 text-2xl">
                Welcome! {{ $page.props.user.name }}
            </div>

            <div class="mt-6 text-gray-500">
                freelanCEntral is a job board that uniquely focuses on unpaid short-term remote
                work. The model is similar to internships in that the worker will not receive
                salaries/allowances, but instead gain relevant experience and
                recommendation/certification from the manager. This concept is particularly helpful for
                workers who may have little to no relevant job experience: for example, fresh
                graduates or even mid-career professionals who need to gain experience for a career
                upgrade or switch. This model also eliminates the need to observe legislative
                requirements and draft formal employment contracts.
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        components: {
        },
    })
</script>
