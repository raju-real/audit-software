<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                <i class="bx bx-home-circle"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.audit-steps.index') }}" class="waves-effect {{ isMainMenuActive('audit-steps,step-questions,question-list,add-question,edit-question') }}">
                <i class="bx bx-list-ol"></i>
                <span>Audit Steps</span>
            </a>
        </li>

        <li class="{{ isMainMenuActive('designations,admins') }}">
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-user"></i>
                <span>Admin/Staff</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('admin.staffs.index') }}" class="{{ isSubMenuActive('admins') }}">
                        <i class="bx bx-chevron-right"></i> Staff List
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.designations.index') }}" class="{{ isSubMenuActive('designations') }}">
                        <i class="bx bx-chevron-right"></i> Designations
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ isMainMenuActive('site-settings') }}">
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-cog"></i>
                <span>Settings</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('admin.site-settings') }}" class="{{ isSubMenuActive('site-settings') }}">
                        <i class="bx bx-chevron-right"></i> Site Settings
                    </a>
                </li>

            </ul>
        </li>
    </ul>
</div>
