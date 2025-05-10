<li class="nav-item">
    <a data-bs-toggle="collapse" href="#appraisals" class="collapsed" aria-expanded="false">
        <i class="fas fa-clipboard-check"></i>
        <p>Appraisals</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="appraisals">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('admin.appraisals.index') }}">
                    <span class="sub-item">Appraisals List</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.appraisals.calendar') }}">
                    <span class="sub-item">Calendar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.appraisals.create') }}">
                    <span class="sub-item">Create New</span>
                </a>
            </li>
        </ul>
    </div>
</li>