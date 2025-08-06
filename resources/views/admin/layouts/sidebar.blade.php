<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="{{ isMainMenuActive('dashboard,audit-wise-activators') }}">
            <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                <i class="bx bx-home-circle"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if(authUserRole() == 'administrator')
        <li class="{{ isMainMenuActive('audits') }}">
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class='bx  bx-folder-open'></i>
                <span>Manage Audit</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('admin.audits.index') }}" class="{{ isSubMenuActive('audits') }}">
                        <i class="bx bx-chevron-right"></i> Audit List
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.audits.create') }}" class="{{ isSubMenuActive('audits') }}">
                        <i class="bx bx-chevron-right"></i> Create Audit
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if (authUserRole() !== 'administrator')
            <li
                class="{{ isMainMenuActive('auditor-audits,auditor-audit-steps,auditor-step-questions,supervisor-audits,supervisor-audit-steps,supervisor-step-questions,review-step-answer,auditor-step-details') }}">
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class='bx  bx-folder'></i>
                    <span>My Audit</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.auditor-audits') }}"
                            class="{{ isSubMenuActive('auditor-audits,auditor-audit-steps,auditor-step-questions,auditor-step-details') }}">
                            <i class="bx bx-chevron-right"></i> As Auditor
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.supervisor-audits') }}"
                            class="{{ isSubMenuActive('supervisor-audits,supervisor-audit-steps,supervisor-step-questions,review-step-answer') }}">
                            <i class="bx bx-chevron-right"></i> As Supervisor
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(authUserRole() == 'administrator')
        <li class="{{ isMainMenuActive('audit-steps,question-list,add-question,edit-question') }}">
            <a href="{{ route('admin.audit-steps.index') }}"
                class="waves-effect {{ isMainMenuActive('audit-steps,step-questions,question-list,add-question,edit-question') }}">
                <i class="bx bx-list-ol"></i>
                <span>Audit Steps</span>
            </a>
        </li>
        @endif

        @if(authUserRole() == 'administrator')
        <li class="{{ isMainMenuActive('designations,staffs') }}">
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-user"></i>
                <span>Admin/Staff</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('admin.staffs.index') }}" class="{{ isSubMenuActive('staffs') }}">
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
        @endif

        @if(authUserRole() == 'administrator')
        <li class="{{ isMainMenuActive('organizations,financial-years') }}">
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class='bx  bx-polygon'></i>
                <span>Organization/F.Y</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('admin.organizations.index') }}" class="{{ isSubMenuActive('organizations') }}">
                        <i class="bx bx-chevron-right"></i> Organization List
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.financial-years.index') }}"
                        class="{{ isSubMenuActive('financial-years') }}">
                        <i class="bx bx-chevron-right"></i> Financial Years
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(authUserRole() == 'administrator')
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
        @endif
    </ul>
</div>
