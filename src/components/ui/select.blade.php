<div class="flex flex-col gap-px relative">
    <div onclick="toggleSelect(event, '{{ $id }}')"
        class="flex justify-between font-semibold  w-full py-2 px-3 rounded-md 
border-2 hover:border-primary border-input bg-background text-sm  
disabled:cursor-not-allowed 
disabled:opacity-50 select-none">
        <p id="selectedLabel-{{ $id }}">{{ $options[0] }}</p>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 stroke-muted-foreground">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>

    </div>
    <div class="z-50">
        <div id="dropdown-{{ $id }}"
            class="hidden bg-background absolute text-sm font-semibold w-full
        border-2 border-input disabled:cursor-not-allowed 
        disabled:opacity-50 select-none rounded-md p-1">
            @foreach ($options as $label)
                <div class="py-2 pl-12 cursor-pointer hover:bg-muted rounded-md"
                    onclick="handleClick(event, '{{ $id }}')">
                    {{ $label }}
                </div>
            @endforeach
        </div>
    </div>
    <input type="hidden" id="selectedValue-{{ $id }}" value="{{ $options[0] }}"
        name="selectedValue-{{ $id }}">
</div>

<script>
    function handleClick(event, id) {
        console.log(event.target.innerText); // Logs the clicked element to the console
        document.getElementById(`selectedLabel-${id}`).innerText = event.target.innerText;
        document.getElementById(`selectedValue-${id}`).value = event.target.innerText;
        console.log(event.target.innerText);
    }

    function toggleSelect(event, id) {
        console.log(id)
        event.stopPropagation();
        let dropdown = document.getElementById(`dropdown-${id}`);
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";

            document.addEventListener('click', function hideDropdown() {
                dropdown.style.display = "none";

                // Remove the event listener after hiding the dropdown
                document.removeEventListener('click', hideDropdown);
            });
        } else {
            dropdown.style.display = "none";
        }
    }
</script>
