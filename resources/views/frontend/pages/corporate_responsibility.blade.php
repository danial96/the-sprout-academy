@extends('frontend.partials.master')

@section('title', 'Corporate Responsibility')

@section('content')
    {{-- Hero Section --}}
    @include('frontend.partials.header_inner', [
        'bgImage' => asset('frontend/assets/home_page_images/hdr-bg-corporate.png'),
        'title' => "THE SPROUT ACADEMY'S GOALS, VALUES, AND BELIEFS",
        'showButton' => false,
    ])

    {{-- Philosophy Section - light teal box, sprout left + text right --}}
    <section class="corp-philosophy-section">
        <div class="container">
            <div class="corp-philosophy-box">
                <div class="corp-philosophy-graphic">
                    <img src="{{ asset('frontend/assets/home_page_images/tree-layer.png') }}" alt="Sprout Academy"
                        class="corp-sprout-graphic" loading="lazy">
                </div>
                <div class="corp-philosophy-content">
                    <p class="corp-philosophy-p">
                        Our goal is to help all students succeed by providing exceptional educational experiences in a safe
                        and nurturing environment. We are committed to fostering a love for learning, critical thinking
                        skills, and a strong sense of community. We believe in providing a holistic approach to education
                        that addresses the intellectual, social, emotional, and physical needs of each child.
                    </p>
                    <p class="corp-philosophy-p">
                        The Sprout Academy's core values, which are Employee Success, Family Success, Social Awareness,
                        Fiscal Responsibility, and Technical Excellence, guide our decisions and actions. These values
                        reflect our commitment to our employees, families, community, and the future.
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- Core Values Timeline (5 values, alternating left/right; you can replace images) --}}
    <section class="difference-timeline-wrapper">
        <div class="container">
            <div class="timeline-line"></div>

            {{-- 01: Employee Success - Text Left, Image Right (orange) --}}
            <div class="timeline-section">
                <div class="timeline-content-wrapper left-content">
                    <div class="timeline-text">
                        <h3 class="timeline-heading">EMPLOYEE SUCCESS</h3>
                        <p class="timeline-paragraph">
                            As a professional employer, childcare and solutions focused organization, we
                            are defined by the quality of our people. At The Sprout Academy we focus on the success, both
                            personally and professionally, of each employee. Our employees' passions for childcare is
                            sustained by providing interesting and challenging roles that utilize current skill sets. The
                            Sprout Academy maintains a continual investment in our employees through both formal and
                            informal education and training. Childcare professionals are drawn to our team by providing a
                            culture
                            of caring, involvement, training, quality benefits, work-life balance,
                            and consistent open and honest communication.
                        </p>
                    </div>
                    <div class="timeline-image">
                        <div class="timeline-image-spacing">
                            <img src="{{ asset('frontend/assets/home_page_images/corporate-img-1.png') }}"
                                alt="Employee Success">
                        </div>
                    </div>
                </div>
                <div class="timeline-icon-center timeline-icon-center--orange"><span>01</span></div>
            </div>

            {{-- 02: Family Success - Image Left, Text Right (dark blue) --}}
            <div class="timeline-section">
                <div class="timeline-content-wrapper right-content">
                    <div class="timeline-image">
                        <div class="timeline-image-spacing">
                            <img src="{{ asset('frontend/assets/home_page_images/corporate-img-2.png') }}"
                                alt="Family Success">
                        </div>
                    </div>
                    <div class="timeline-text">
                        <h3 class="timeline-heading">FAMILY SUCCESS</h3>
                        <p class="timeline-paragraph">
                            Family success is more than just family satisfaction. At The Sprout Academy,
                            we focus on helping our families meet their objectives for their child together. We accomplish
                            this by providing the services and solutions of highly dedicated, results-oriented, world-class
                            childcare professionals with the domain knowledge necessary to accomplish the task at hand. The
                            Sprout Academy understands that forming a partnership with our families, listening to their
                            needs, maintaining constant communication, and establishing shared goals are the keys to
                            solving complex problems.
                        </p>
                    </div>
                </div>
                <div class="timeline-icon-center timeline-icon-center--blue"><span>02</span></div>
            </div>

            {{-- 03: Social Awareness - Text Left, Image Right (green) --}}
            <div class="timeline-section">
                <div class="timeline-content-wrapper left-content">
                    <div class="timeline-text">
                        <h3 class="timeline-heading">SOCIAL AWARENESS</h3>
                        <p class="timeline-paragraph">
                            As a corporation, we believe it is important to give back to the community in which we live and
                            work. The Sprout Academy both supports & encourages
                            the causes and charities that are important to our employees.
                        </p>
                    </div>
                    <div class="timeline-image">
                        <div class="timeline-image-spacing">
                            <img src="{{ asset('frontend/assets/home_page_images/corporate-img-3.png') }}"
                                alt="Social Awareness">
                        </div>
                    </div>
                </div>
                <div class="timeline-icon-center timeline-icon-center--green"><span>03</span></div>
            </div>

            {{-- 04: Fiscal Responsibility - Image Left, Text Right (dark blue) --}}
            <div class="timeline-section">
                <div class="timeline-content-wrapper right-content">
                    <div class="timeline-image">
                        <div class="timeline-image-spacing">
                            <img src="{{ asset('frontend/assets/home_page_images/corporate-img-4.png') }}"
                                alt="Fiscal Responsibility">
                        </div>
                    </div>
                    <div class="timeline-text">
                        <h3 class="timeline-heading">FISCAL RESPONSIBILITY</h3>
                        <p class="timeline-paragraph">
                            Fiscally responsible business execution ensures that The Sprout Academy remains a viable
                            organization able to meet our obligations and responsibilities to our employees, our partners,
                            and our families. As such, The Sprout Academy focuses on consistent revenue and profit
                            performance. The profit is then invested into the success of our families and employees,
                            maintaining our advantage, and contributing to many charitable and social causes within our
                            community that further enable the fruition of The Sprout Academy's Vision.
                        </p>
                    </div>
                </div>
                <div class="timeline-icon-center timeline-icon-center--blue"><span>04</span></div>
            </div>

            {{-- 05: Technical Excellence - Text Left, Image Right (orange) --}}
            <div class="timeline-section">
                <div class="timeline-content-wrapper left-content">
                    <div class="timeline-text">
                        <h3 class="timeline-heading">TECHNICAL EXCELLENCE</h3>
                        <p class="timeline-paragraph">
                            The Sprout Academy recognizes that we must constantly evaluate and invest in the latest emerging
                            technologies and work to prepare our staff for the ever-dynamic nature of our business. As such,
                            we make significant investments to ensure that our employees are well educated, well trained,
                            and well versed in the technologies required ensuring the success of our children. These skills
                            are augmented by a wealth of experience and solid consulting skills that rank our childcare
                            professionals among the best in the industry.
                        </p>
                    </div>
                    <div class="timeline-image">
                        <div class="timeline-image-spacing">
                            <img src="{{ asset('frontend/assets/home_page_images/corporate-page-img-6.png') }}"
                                alt="Technical Excellence">
                        </div>
                    </div>
                </div>
                <div class="timeline-icon-center timeline-icon-center--orange"><span>05</span></div>
            </div>
        </div>
    </section>

    {{-- Commitment Section --}}
    <section class="corp-commitment-section">
        <div class="container">
            <h2 class="corp-commitment-heading">OUR GOALS ARE ACCOMPLISHED BY A COMMITMENT FROM EVERY EMPLOYEE. OUR BELIEFS
                AND VALUES REQUIRE THAT WE:</h2>
            <ul class="corp-commitment-list">
                <li>Treat each employee with respect and give him/her the opportunity for input on how to continually
                    improve our service goals</li>
                <li>Treat each employee with mutual respect. The company does not tolerate discrimination of any kind and
                    encourages all managers and
                    supervisors to involve employees in problem solving and the creativity process. When problems arise, the
                    facts should be analyzed
                    to determine ways to avoid similar problems in the future.</li>
                <li>Provide the most effective and efficient corrective action to resolve family and child issues, to ensure
                    our families’ satisfaction and that the problem not be repeated in the future.</li>
                <li>Foster an open door policy that encourages interaction, discussions, and ideas to improve the work
                    environment, thus increasing our productivity</li>
                <li>Deliver cost competitive services to our families, employees and where required, partner our families
                    with other companies who share
                    our mission, vision, and values.</li>
            </ul>
        </div>
    </section>

    {{-- Footer CTA / Newsletter is included via master layout --}}
@endsection
