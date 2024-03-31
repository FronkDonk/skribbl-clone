{{-- <select id="{{ $name }}" name="{{ $name }}"
    class="block w-full py-2 px-3 rounded-md border border-input bg-background text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
    @foreach ($options as $value => $label)
        <option class="py-1 hover:bg-muted-foreground text-sm bg-background text-muted-foreground"
            value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select> --}}

<div class="flex flex-col gap-px relative">
    <div onclick="toggleSelect(event)"
        class="flex justify-between font-semibold  w-full py-2 px-3 rounded-md 
border-2 hover:border-primary border-input bg-background text-sm  
disabled:cursor-not-allowed 
disabled:opacity-50 select-none">
        <p id="selectLabel">{{ $label }}</p>
        <p>chevron</p>
    </div>
    <div class="z-50">
        <div id="dropdown"
            class="hidden bg-background absolute text-sm font-semibold w-full
        border-2 border-input disabled:cursor-not-allowed 
        disabled:opacity-50 select-none rounded-md p-1">
            @foreach ($options as $label)
                <div class="py-2 pl-12 cursor-pointer hover:bg-muted rounded-md" onclick="handleClick(event)">
                    {{ $label }}
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function handleClick(event) {
        console.log(event.target.innerText); // Logs the clicked element to the console
        document.getElementById('selectLabel').innerText = event.target.innerText;
    }

    function toggleSelect(event) {
        event.stopPropagation();
        let dropdown = document.getElementById('dropdown');
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";
        } else {
            dropdown.style.display = "none";
        }
    }

    document.addEventListener('click', function() {
        let dropdown = document.getElementById('dropdown');
        dropdown.style.display = "none";
    });
</script>
