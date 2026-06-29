@extends('frontend.partials.master')

@section('title', 'Non-Discrimination Policy')

@section('content')
    {{-- Hero Section --}}
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-non-discrimination.png'),
        'title' => 'NON-DISCRIMINATION POLICY FOR STUDENT ENROLLMENT',
        'showButton' => false,
    ])

    {{-- Intro: same style as corp-philosophy-section – image left, text right in light aqua box --}}
    <section class="ndp-intro-section">
        <div class="container">
            <div class="ndp-intro-box">
                <div class="ndp-intro-graphic">
                    <img src="{{ asset('frontend/assets/home_page_images/child-1.png') }}" alt="Student"
                        class="ndp-intro-image" loading="lazy">
                </div>
                <div class="ndp-intro-content">
                    <p class="ndp-intro-p">The Sprout Academy is committed to providing a welcoming, inclusive, and
                        respectful environment for all children and families. We believe every child deserves equal access
                        to early childhood education and care.
                    </p>
                    <p class="ndp-intro-p">Enrollment at The Sprout Academy is open to all children without regard to race,
                        color, national origin, ethnicity, ancestry, religion, sex, gender, gender identity, sexual
                        orientation, family structure, disability, medical condition, or socioeconomic status.</p>
                    <p class="ndp-intro-p">We do not discriminate in admission, education, classroom activities,
                        or access to programs and services. All children are given equal opportunity to learn, participate,
                        and thrive in a safe and
                        supportive setting</p>
                </div>
            </div>
        </div>
    </section>

    {{-- THE SPROUT ACADEMY IS COMMITTED TO --}}
    <section class="ndp-section">
        <div class="container">
            <h2 class="ndp-pill-heading ndp-pill-heading--blue">THE SPROUT ACADEMY IS COMMITTED TO:</h2>
            <div class="ndp-content">
                <ul class="ndp-list">
                    <li>Treating all children and families with dignity and respect</li>
                    <li>Providing inclusive learning environments that reflect diverse backgrounds and experiences</li>
                    <li>Making reasonable accommodations for children with disabilities or special needs, in accordance with
                        applicable laws and best practices</li>
                    <li>Ensuring policies and practices are applied fairly and consistently</li>
                </ul>
                <p>Families seeking enrollment will be considered based on program availability, age requirements, and the
                    preschool’s ability to meet each child’s needs in a safe and supportive environment — never based on
                    personal or protected characteristics.
                </p>

                <p>This policy applies to all aspects of enrollment, program participation, and school community engagement.
                </p>

                <p>For questions about this policy or enrollment practices, please contact our centers at any time.</p>
            </div>
        </div>
    </section>

    {{-- NON-DISCRIMINATION POLICY FOR EMPLOYMENT --}}
    <section class="ndp-section">
        <div class="container">
            <h2 class="ndp-pill-heading ndp-pill-heading--blue">NON-DISCRIMINATION POLICY FOR EMPLOYMENT</h2>
            <h3 class="ndp-subheading">Equal Employment Opportunity</h3>
            <div class="ndp-content">
                <p>The Sprout Academy is committed to providing equal employment opportunities. We do not and shall not
                    discriminate against a person because of his/her race, age, color, religion, sex, national origin,
                    ancestry, citizenship, disability/handicap, veteran status, pregnancy, marital status, or other
                    applicable legally protected category in any aspect of the employment relationship. Our policy of equal
                    opportunity and nondiscrimination extends to recruitment, hiring, employment, training and development,
                    promotion, transfer, termination, layoff, compensation, and all other conditions and privileges of
                    employment, in accordance with applicable federal, state and local laws. If at any time during the
                    application process or during the period of your employment you believe you have been subjected to
                    discrimination, you must contact The Sprout Academy management immediately. All complaints will be
                    thoroughly investigated and appropriate remedial action will be taken. No applicant or employee will be
                    retaliated against for, in good faith, reporting discrimination or participating in such an
                    investigation.
                    Violation of this policy may result in disciplinary action up to and including termination.</p>
            </div>
        </div>
    </section>

    {{-- ANTI-HARASSMENT --}}
    <section class="ndp-section">
        <div class="container">
            <h2 class="ndp-pill-heading ndp-pill-heading--green">ANTI-HARASSMENT</h2>
            <div class="ndp-content">
                <p>All employees of The Sprout Academy have a right to work in a professional atmosphere that promotes equal
                    opportunity and prohibits discriminatory practices, including harassment. The Sprout Academy has adopted
                    a Zero Tolerance Policy in this regard and will not, under any circumstances, condone or tolerate
                    harassment of employees. We prohibit all forms of harassment relating to an employee's race, age, color,
                    religion, sex, national origin, ancestry, citizenship, disability/handicap, veteran status, pregnancy,
                    marital status, or other applicable legally protected basis. Any comments or conduct based on, or
                    relating to the above-described categories that fail to respect the dignity and feelings of the
                    individual are unacceptable. Conduct that fails to comply with both the letter and spirit of this policy
                    will not be tolerated. This policy applies to all employees of the company.  You must conduct yourself
                    in a manner consistent with this policy and respect the rights of co-workers, clients, children and
                    their parents, vendors and other visitors to your child care center. Violation of this policy may
                    result in disciplinary action up to and including termination.
                </p>
                <h4 class="ndp-subheading-sm">Definition</h4>
                <p>For these purposes, the term harassment includes, but is not limited to, slurs, jokes, other verbal,
                    graphic, or physical conduct relating to a person's race, age, color, religion, sex, national origin,
                    ancestry, citizenship, disability/handicap, veteran status, pregnancy, marital status, or other
                    applicable legally protected basis; or any other conduct that is offensive or abusive based on the
                    above-described categories. Harassment also including hitting, pushing or other physical contact or
                    threats (implicit or explicit) to act based on the
                    above-described categories.</p>
                <h4 class="ndp-subheading-sm">Harassment also includes:</h4>
                <ul class="ndp-list">
                    <li>Unwelcome or unwanted sexual advances</li>
                    <li>Request(s) or demand(s) for sexual favors; including subtle or blatant expectations, pressures, or
                        requests for any type of favor</li>
                    <li>Any other physical or verbal conduct of sexual or otherwise offensive nature where:</li>
                </ul>
                <p>If you feel that another employee is harassing you, client, parent, vendor, or other visitors to your
                    childcare center, or witness another employee of the company being harassed in violation of this policy,
                    you must report this harassment immediately to The Sprout Academy management. All harassment complaints
                    under this policy will be thoroughly investigated and confidentially will be maintained to the maximum
                    extent possible under the circumstances. If harassment is found to have occurred, appropriate
                    disciplinary action, including immediate discharge, will be taken. If you make a good faith complaint
                    under this policy, you will be treated courteously and the problem will be handled as swiftly and as
                    discreetly as possible in necessary. The good faith registration of a complaint or participation in an
                    investigation in good faith will in no way be used against you nor will it have an adverse impact on
                    your employment status. The Sprout Academy will not retaliate against an employee who reports harassment
                    or participates in an investigation and will not knowingly permit retaliation by management or other
                    employees. Retaliation is a serious violation of this anti-harassment policy and must be reported to The
                    Sprout Academy management.</p>

                <h4 class="ndp-subheading-sm">Definitions of Harassment</h4>
                <p>Sexual harassment constitutes discrimination and is illegal under federal, state and local laws. For the
                    purposes of this policy, sexual harassment is defined, as in the Equal Employment Opportunity Commission
                    Guidelines, as unwelcome sexual advances, requests for sexual favors and other verbal or physical
                    conduct of a sexual nature when, for example a) submission to such conduct is made either explicitly or
                    implicitly a term or condition of an individual's employment; b) submission to or rejection of such
                    conduct by an individual is used as the basis for employment decisions affecting such individual; or c)
                    such conduct has the purpose or effect of unreasonably interfering with an individual's work performance
                    or creating an intimidating, hostile or offensive working environment.</p>

                <p>Sexual harassment may include a range of subtle and not-so-subtle behaviors and may involve individuals
                    of the same or different gender. Depending on the circumstances, these behaviors may include unwanted
                    sexual advances or requests for sexual favors; sexual jokes and innuendo; verbal abuse of a sexual
                    nature; commentary about an individual's body, sexual prowess or sexual deficiencies; leering, whistling
                    or touching; insulting or obscene comments or gestures; display in the workplace of sexually suggestive
                    objects or pictures; and other physical, verbal or visual conduct of a sexual nature.</p>

                <p>Harassment on the basis of any other protected characteristic is also strictly prohibited. Under this
                    policy, harassment is verbal, written or physical conduct that denigrates or shows hostility or aversion
                    toward an individual because of his/her race, color, religion, gender, sexual orientation, national
                    origin, age, disability, marital status, citizenship, genetic information or any other characteristic
                    protected by law or that of his/her relatives, friends or associates, and that a) has the purpose or
                    effect of creating an intimidating, hostile or offensive work environment; b) has the purpose or effect
                    of unreasonably interfering with an individual's work performance; or c) otherwise adversely affects an
                    individual's employment opportunities.</p>

                <p>Harassing conduct includes epithets, slurs or negative stereotyping; threatening, intimidating or hostile
                    acts; denigrating jokes; and written or graphic material that denigrates or shows hostility or aversion
                    toward an individual or group and that is placed on walls or elsewhere on the employer's premises or
                    circulated in the workplace, on company time or using company equipment via e-mail, phone (including
                    voice messages), text messages, tweets, blogs, social networking sites or other means.</p>

                <h4 class="ndp-subheading-sm">Individuals and Conduct Covered</h4>
                <p>These policies apply to all applicants and employees, whether related to conduct engaged in by fellow
                    employees or someone not directly connected to The Sprout Academy (e.g., an outside vendor, consultant
                    or customer).</p>

                <p>Conduct prohibited by these policies is unacceptable in the workplace and in any work-related setting
                    outside the workplace, such as during business trips, business meetings and business-related social
                    events.</p>
            </div>
        </div>
    </section>

    {{-- WORKPLACE BULLYING --}}
    <section class="ndp-section">
        <div class="container">
            <h2 class="ndp-pill-heading ndp-pill-heading--orange">WORKPLACE BULLYING</h2>
            <div class="ndp-content">
                <p>The Sprout Academy defines bullying as “repeated inappropriate behavior, either direct or indirect,
                    whether verbal, physical or otherwise, conducted by one or more persons against another or others, at
                    the place of work and/or in the course of employment.” Such behavior violates the company policies
                    regarding code of conduct, which clearly states that all employees will be treated with dignity and
                    respect.</p>
                <p>The purpose of this policy is to communicate to all employees, including administrator, faculty, staff
                    members, volunteers and students that the school will not tolerate bullying behavior. Employees found in
                    violation of this policy will be disciplined up to and including termination.</p>

                <p>Bullying may be intentional or unintentional. However, it must be noted that where an allegation of
                    bullying is made, the intention of the alleged bully is irrelevant and will not be given consideration
                    when meting out discipline. As in sexual harassment, it is the effect of the behavior upon the
                    individual that is important. The Sprout Academy considers the following types of behavior examples of
                    bullying:</p>

                <h4 class="ndp-subheading-sm">Verbal bullying</h4>
                <p>Slandering, ridiculing or maligning a person or his/her family; persistent name calling that is hurtful,
                    insulting or humiliating; using a person as the
                    butt of jokes; abusive and offensive remarks.</p>

                <h4 class="ndp-subheading-sm">Physical bullying</h4>
                <p>Pushing, shoving, hitting, slapping, hair pulling, pinching, kicking, or any other physical contact that
                    is harmful or causes pain or injury; throwing objects at a person; or making threatening gestures.</p>

                <h4 class="ndp-subheading-sm">Gesture bullying</h4>
                <p>Nonverbal threatening gestures or glances that convey threatening messages.</p>

                <h4 class="ndp-subheading-sm">Gesture bullying</h4>
                <p>Nonverbal threatening gestures or glances that convey threatening messages.</p>
            </div>
        </div>
    </section>

    {{-- THE AMERICANS WITH DISABILITIES ACT (ADA) --}}
    <section class="ndp-section">
        <div class="container">
            <h2 class="ndp-pill-heading ndp-pill-heading--blue">THE AMERICANS WITH DISABILITIES ACT (ADA)</h2>
            <div class="ndp-content">
                <p>The American with Disabilities Act (ADA) prohibits discrimination based on disability and protects
                    qualified applicants and employees with disabilities from discrimination in all aspects of employment. A
                    qualified individual with a disability is an individual with a physical or mental impairment that
                    substantially limits one or more major life activities, meets the job requirements for the position held
                    or desired, and who, with or without reasonable accommodation, can perform the essential functions of
                    the position. </p>

                <p>The Sprout Academy is committed to providing equal employment opportunities to qualified individuals with
                    disabilities, which includes providing reasonable accommodations where appropriate. If you require
                    accommodation to perform essential functions of the job, you must notify The Sprout Academy management
                    to request such accommodation. Upon doing so, you will participate in an interactive process with the
                    company to identify the precise limitations the disability causes and the potential accommodations that
                    could overcome those limitations. In this process you will be asked for you input regarding the type of
                    accommodation you believe may be necessary or the functional limitations caused by your disability.
                    Also, when appropriate, we may need your permission to obtain additional information from your physician
                    or other health care professionals. Necessary accommodation will be made unless precluded by an undue
                    hardship or other permissible consideration.</p>

                <p>If you believe you have been discriminated against under the ADA, you must bring your concern directly to
                    The Sprout Academy management. If your complaint relates to The Sprout Academy management personnel,
                    notify the President or an officer of The Sprout Academy.</p>

                <p>If there is a determination that discrimination has occurred, appropriate remedial action will be taken.
                    You will not be retaliated against for, in good faith, filing a complaint. All issues involving ADA will
                    be kept as confidential as possible under the circumstances. Violation of this policy may result in
                    disciplinary action up to and including termination.</p>
            </div>
        </div>
    </section>
@endsection
