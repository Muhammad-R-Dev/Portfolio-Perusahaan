import os
import re

base_dir = r'c:\Users\hp\Documents\project\Magang\resources\views\admin'
pages_dir = os.path.join(base_dir, 'pages')
layouts_dir = os.path.join(base_dir, 'layouts')
partials_dir = os.path.join(layouts_dir, 'partials')

# Read dashboard to extract layout
with open(os.path.join(pages_dir, 'dashboard.blade.php'), 'r', encoding='utf-8') as f:
    dashboard_content = f.read()

# Extract head part
head_match = re.search(r'(<!DOCTYPE html>.*?</head>\s*<body>)', dashboard_content, re.DOTALL)
head_part = head_match.group(1) if head_match else ''

# Extract common scripts
scripts_match = re.search(r'(<!-- JavaScript Scripts -->.*?// Pastikan semua menu tertutup di awal.*?\}\);\s*</script>)', dashboard_content, re.DOTALL)
if not scripts_match:
    # fallback to find until </body>
    scripts_match = re.search(r'(<!-- JavaScript Scripts -->.*?</script>)', dashboard_content, re.DOTALL)

common_scripts = scripts_match.group(1) if scripts_match else ''

# Add localStorage to switch mode in common_scripts
common_scripts = common_scripts.replace("document.body.classList.add('dark');", 
    "document.body.classList.add('dark');\n\t\t\t\tlocalStorage.setItem('theme', 'dark');")
common_scripts = common_scripts.replace("document.body.classList.remove('dark');", 
    "document.body.classList.remove('dark');\n\t\t\t\tlocalStorage.setItem('theme', 'light');")

# Add initialization block
init_block = '''
		// Initialize theme from localStorage
		const savedTheme = localStorage.getItem('theme');
		if (savedTheme === 'dark') {
			document.body.classList.add('dark');
			if (switchMode) switchMode.checked = true;
		}
'''
common_scripts = common_scripts.replace("switchMode.addEventListener('change', function () {", init_block + "\n\t\tswitchMode.addEventListener('change', function () {")

# Extract navbar
nav_match = re.search(r'(<nav>.*?</nav>)', dashboard_content, re.DOTALL)
nav_part = nav_match.group(1) if nav_match else ''
nav_part = re.sub(r'<a href="#" class="nav-link">.*?</a>', r'<a href="#" class="nav-link">@yield(\'nav-title\', \'Dashboard\')</a>', nav_part)

with open(os.path.join(partials_dir, 'navbar.blade.php'), 'w', encoding='utf-8') as f:
    f.write(nav_part)

# Construct app.blade.php
# Replace title in head
head_part = re.sub(r'<title>.*?</title>', r'<title>@yield(\'title\', \'AdminHub\')</title>', head_part)

app_blade = f'''{head_part}

	{{{{-- SIDEBAR --}}}}
	@include('admin.layouts.partials.sidebar')

	<!-- CONTENT -->
	<section id="content">
		{{{{-- NAVBAR --}}}}
		@include('admin.layouts.partials.navbar')

		@yield('content')
	</section>
	<!-- CONTENT -->

	@stack('modals')

{common_scripts}
	@stack('scripts')
</body>
</html>'''

with open(os.path.join(layouts_dir, 'app.blade.php'), 'w', encoding='utf-8') as f:
    f.write(app_blade)

# Process all pages
for file_name in os.listdir(pages_dir):
    if not file_name.endswith('.blade.php'): continue
    file_path = os.path.join(pages_dir, file_name)
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Extract title
    title_match = re.search(r'<title>(.*?)</title>', content)
    title = title_match.group(1) if title_match else 'AdminHub'

    # Extract nav title
    nav_title_match = re.search(r'<a href="#" class="nav-link">(.*?)</a>', content)
    nav_title = nav_title_match.group(1) if nav_title_match else 'Dashboard'

    # Extract main content
    main_match = re.search(r'(<main>.*?</main>)', content, re.DOTALL)
    main_content = main_match.group(1) if main_match else ''

    # Extract modals (anything between </main> and <!-- JavaScript Scripts -->, excluding closing section/content tags)
    modals_match = re.search(r'</main>\s*<!-- MAIN -->\s*</section>\s*<!-- CONTENT -->\s*(.*?)\s*<!-- JavaScript Scripts -->', content, re.DOTALL)
    if not modals_match:
        modals_match = re.search(r'</main>.*?(<div class="modal.*?>.*?</div>)\s*<!-- JavaScript Scripts -->', content, re.DOTALL)
        
    modals_content = modals_match.group(1) if modals_match else ''
    modals_content = modals_content.strip()

    # Extract custom scripts
    # Find scripts after the common script end
    custom_scripts = ''
    script_block_match = re.search(r'<!-- JavaScript Scripts -->\s*<script>(.*?)</script>', content, re.DOTALL)
    if script_block_match:
        full_script = script_block_match.group(1)
        # Assuming common script ends with DOMContentLoaded block
        common_end = 'menu.style.display = \\\'none\\\';\\n\\t\\t  });\\n\\t\\t});'
        # let's try a regex approach to find custom parts
        custom_match = re.search(r'// Pastikan semua menu tertutup di awal.*?\}\);(.*)', full_script, re.DOTALL)
        if custom_match:
            custom_part = custom_match.group(1).strip()
            if custom_part:
                custom_scripts = f'<script>\n{custom_part}\n</script>'

    # Reconstruct the page
    new_page = f'''@extends('admin.layouts.app')

@section('title', '{title}')
@section('nav-title', '{nav_title}')

@section('content')
{main_content}
@endsection
'''
    if modals_content:
        new_page += f'''
@push('modals')
{modals_content}
@endpush
'''
    if custom_scripts:
        new_page += f'''
@push('scripts')
{custom_scripts}
@endpush
'''

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(new_page)

print('Done rewriting pages.')
